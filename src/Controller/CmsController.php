<?php

namespace App\Controller;

use App\Api\Client;
use App\Api\Request\Unit;
use App\Exceptions\BadResponseException;
use App\Exceptions\MalformedRequestException;
use App\Exceptions\OrdersListEmptyResponseException;
use App\Wrappers\Order;
use App\Wrappers\ZOrder;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Proxy;
use App\Twig\Render;
use App\Api\Fields as Api;
use App\Api\Loader;
use App\Api\Request\Builder;
use App\Api\Request\Validator as RequestValidator;
use App\Api\Response\Builder as ResponseBuidser;
use App\Api\Response\Validator;
use App\Exceptions\MalformedResponseException;
use App\Exceptions\MalformedApiKeyException;
use App\Api\Process;
use App\Helpers\Output;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Serializer\Encoder\JsonEncode;


class CmsController extends BaseController implements Api
{

    /**
     * @Route("/cmsapi/data1")
     * @return HttpResponse
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function data1()
    {
        // GET переменные
        $get = self::getRequest()->query->all();

        $query = "SELECT * FROM orders ORDER BY id DESC LIMIT 5";
        $sth = Proxy::init()->getConnection()->query($query);
        $sth->execute();
        $res = $sth->fetchAll();

        $data['content'] = \GuzzleHttp\json_encode($res);
        return (new Render())->render($data);
    }

    /**
     * @Route("/cmsapi/orders")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\DBAL\DBALException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function loadOrders()
    {

        $get = self::getRequest()->query->all();
        if (isset($get[Api::CLIENT_ID])) {
            $orderStat = (new Loader())->loadClientsJoinOrders($get[Api::CLIENT_ID]);
            if (count($orderStat)) {
                $unitList[] = (new Unit())->set($orderStat[0], $get);

            } else {
                die('Все ордера загружены');
            }
        } else {
            $orderStat = (new Loader())->loadClientsJoinOrders();
            /** @var Unit[] $unitList */
            $unitList = (new Builder())->set(
                $orderStat,
                self::getRequest()
            )->getUnitlist();
        }

        $content = 'Orders loaded';
        try {
//            Proxy::init()->getLogger()->addWarning('UnitList: ' .\GuzzleHttp\json_encode($unitList));
            $response = (new Client())->process($unitList);
            (new Validator())->validateOrdersList($response);

            if (isset($response[0]->status) && $response[0]->status == 400) {
                $content = 'Error';
            } else {
                $currentChangeDate = (new ResponseBuidser())->process($response);
                $lastTime = (new Loader())->loadOption(\Options::ORDERS_UPDATE);
                $this->compareOptionsLastUpdateTime($currentChangeDate, $lastTime);

            }
        } catch (MalformedResponseException $e) {
            $content = $e->getMessage();
        } catch (OrdersListEmptyResponseException $e) {
            $content = $e->getMessage();
        }

        Proxy::init()->getConnection()->close();

        return (new Render())->render([
            Render::CONTENT => $content
        ]);
    }

    /**
     * @param \DateTime $current
     * @param \Options $lastTime
     * @throws \Exception
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private  function compareOptionsLastUpdateTime(\DateTime $current, \Options $lastTime)
    {
//        $lastChangeTime = $lastTime->getOrdersUpdateLastDatetime();
        $checkTime = (new \DateTime())->sub(
            new \DateInterval(Api::MAX_LOAD_UPDATE_INTERVAL)
        );
        if($current > $checkTime) {
            $lastTime->setOrdersUpdateLastDatetime($current);
            Proxy::init()->getEntityManager()->persist($lastTime);
            Proxy::init()->getEntityManager()->flush();
        }
    }

    /**
     * @Route("/cmsapi/ordersqty")
     * @return HttpResponse
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function loadOrdersQty()
    {
        $clentIdList = (new Loader())->loadClientsListIds(
            self::getRequest()->query->all()[self::CLIENT_ID_FROM],
            self::getRequest()->query->all()[self::CLIENT_ID_TO]
        );

        $message = 'success';

        try {
            $response = (new Client())->sendOrdersQtyRequest($clentIdList);
//            echo '<pre>'; var_dump($response); die;
            (new Validator())->validateOrdersList($response);
            (new ResponseBuidser())->saveOrdersCount($response);
        } catch (MalformedResponseException $e) {
            $message = $e->getMessage();
        }

        Proxy::init()->getConnection()->close();

        return (new Render())->render([
            Render::CONTENT => $message
        ]);
    }


    /**
     * @Route("/cmsapi/ordersupdate")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function loadOrdersUpdate()
    {
        $lastTime = (new Loader())->loadOption(\Options::ORDERS_UPDATE);
        $lastId = (new Loader())->loadOption(\Options::ORDERS_LAST_ID);
        $useId = (new Loader())->loadOption(\Options::ORDERS_USE_ID);
        Proxy::init()->getLogger()->addWarning('BiggestOrderId: ' . (new Loader())->loadBiggestOldId());
        try {
            $response = (new Client())->sendOrdersUpdateRequest(
                $lastTime->getOrdersUpdateLastDatetime(),
                $useId->getValue() ? $lastId->getValue() : Api::ZERO,
                (new Loader())->loadBiggestOldId(),
                self::getRequest()
            );

            (new Validator())->validateOrdersList($response);
            if (isset($response->status) && $response->status == 400) {
                $content = 'Error';
                Proxy::init()->getLogger()->addWarning('Error: ' . $content);
            } else {
                $options = (new Process())->processUpdate($response);
                $lastTime->setOrdersUpdateLastDatetime($options[\Options::ORDERS_UPDATE]);
                $lastId->setValue($options[\Options::ORDERS_LAST_ID]);
                $useId->setValue($options[\Options::ORDERS_USE_ID]);
                Proxy::init()->getEntityManager()->persist($lastTime);
                Proxy::init()->getEntityManager()->persist($lastId);
                Proxy::init()->getEntityManager()->persist($useId);
                Proxy::init()->getEntityManager()->flush();
            }
        } catch (MalformedResponseException $e) {
            $message = $e->getMessage();
            Proxy::init()->getLogger()->addWarning('MalformedResponseException: ' . $e->getMessage());
        } catch (\Exception $e) {
            Proxy::init()->getLogger()->addWarning('Exception: ' . $e->getMessage());
        }
        Proxy::init()->getConnection()->close();
        return (new Render())->render([
            Render::CONTENT => $lastTime->getOrdersUpdateLastDatetime()->format('c')
        ]);
    }


    /**
     * Метод с авторизацией
     *
     * @Route("/is_auth")
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function isAuthMethod()
    {
        return (new Render())->render([
            Render::CONTENT => 'Hello ' . $this->getUser()->getName()
        ]);
    }


    /**
     * метод без авторизации
     *
     * @Route("/is_not_auth")
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function isNotAuthMethod()
    {
        return (new Render())->render([
            Render::CONTENT => 'YES'
        ]);
    }

    /**
     * @Route("/api/v1/getStatusv2")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function statusV3()
    {
        $content = 'OK';
        try {
            (new RequestValidator())->validateStatusV3Request(self::getRequest());
            $clienSettings = Proxy::init()->getEntityManager()->getRepository(\ClientSettings::class)
                ->findOneBy([\ClientSettings::API_KEY => self::getRequest()->get(Api::KEY)]);
            (new RequestValidator())->validateApiKey(
                $clienSettings,
                'Incorrect Api Key'
            );
            $dateFrom = \DateTime::createFromFormat(
                \Options::FORMAT,
                self::getRequest()->get(Api::FIELD_FROM)
            );
            (new RequestValidator())->validateNotBlank($dateFrom, 'Incorrect field: ' . Api::FIELD_FROM);

            $dateTo = \DateTime::createFromFormat(
                \Options::FORMAT,
                self::getRequest()->get(Api::FIELD_TO)
            );
            (new RequestValidator())->validateNotBlank($dateTo, 'Incorrect field: ' . Api::FIELD_TO);

            $interval = date_diff($dateTo, $dateFrom);
            $dateDiff = $interval->format('%a');

            (new RequestValidator())->validateDateDiff($dateDiff, Api::LIMIT_DAYS_API_V3);

            $orders = (new Loader())->loadApiV3Orders(
                $clienSettings,
                $dateFrom,
                $dateTo
            );

            $porders = (new Loader())->loadPorders($orders);
            $marks = (new Loader())->loadMarks();

            $ordersData = (new ResponseBuidser())->buildStatusV3($orders, $porders, $marks);


            $code = HttpResponse::HTTP_OK;
//            $content = ['status' => $code, 'response' => $ordersData];


        } catch (MalformedRequestException $e) {

            return $this->error($e);

        } catch (MalformedApiKeyException $e) {

            return $this->error($e, HttpResponse::HTTP_UNAUTHORIZED);

        }

        Proxy::init()->getConnection()->close();

        return $this->success($ordersData);
    }

    /**
     *
     * @Route("/api/v1/getStatus")
     *
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getStatus()
    {
        try {
            $innerId = self::getRequest()->get(Api::INNER_N, 0);
            $orderId = self::getRequest()->get(Api::ORDER_ID, 0);

            // если нет ни одно или переданны оба значения
            // мы принимаем только одно значение
            if ((!$innerId && !$orderId) || ($innerId && $orderId)) {
                throw new \Exception(sprintf("Error request: One field required %s or %s", Api::INNER_N, Api::ORDER_ID));
            }

            $client = $this->getClientSettings();

            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq(\Zorders::CLIENT, $client));

            if (!empty($innerId)) {
                $criteria->andWhere(Criteria::expr()->eq(\Orders::INNER_N, $innerId));
            } else {
                $criteria->andWhere(Criteria::expr()->eq(\Orders::ORDER_ID, $orderId));
            }

            $order = \Orders::findOrFail($criteria)->first();

            $wrapperOrder = new Order($order);
            if ($client->getClientId() === 1584 || $client->getClientId() === 1489) {
                $wrapperOrder->findUpdateDateReason();
            }

            $options = [];
            if ($client->getClientId() === 1391) {
                $options['options'] = [
                    'reciepient_name' => $wrapperOrder->reciepient,
                    'doc_description' => $order->getOrderSettings()->getDocDescription(),
                    'delivery_time' => $order->getChangeDate()->getTimestamp(),
                ];
            }

            return $this->success($wrapperOrder, $options);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     *
     * @Route("/api/v1/getZStatus")
     *
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getZStatus()
    {
        try {
            $innerId = self::getRequest()->get(Api::INNER_N, 0);
            $orderId = self::getRequest()->get(Api::ZORDER_ID, 0);

            // если нет ни одно или переданны оба значения
            // мы принимаем только одно значение
            if ((!$innerId && !$orderId) || ($innerId && $orderId)) {
                throw new \Exception(sprintf("Error request: One field required %s or %s", Api::INNER_N, Api::ZORDER_ID));
            }

            $client = $this->getClientSettings();

            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq(\Zorders::CLIENT, $client));

            if (!empty($innerId)) {
                $criteria->andWhere(Criteria::expr()->eq(\Zorders::INNER, $innerId));
            } else {
                $criteria->andWhere(Criteria::expr()->eq(\Zorders::ID, $orderId));
            }

            $order = \Zorders::findOrFail($criteria)->first();
            return $this->success(new ZOrder($order));
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
}