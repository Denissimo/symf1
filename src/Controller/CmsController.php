<?php

namespace App\Controller;

use App\Controller\Api\Client;
use App\Controller\Api\Request\Unit;
use App\Exceptions\BadResponseException;
use App\Exceptions\MalformedRequestException;
use App\Exceptions\OrdersListEmptyResponseException;
use App\Wrappers\Order;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Proxy;
use App\Twig\Render;
use App\Controller\Api\Fields as Api;
use App\Controller\Api\Loader;
use App\Controller\Api\Request\Builder;
use App\Controller\Api\Request\Validator as RequestValidator;
use App\Controller\Api\Response\Builder as ResponseBuidser;
use App\Controller\Api\Response\Validator;
use App\Exceptions\MalformedResponseException;
use App\Controller\Api\Process;
use App\Helpers\Output;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Serializer\Encoder\JsonEncode;

class CmsController extends BaseController implements Api
{

    /**
     * @Route("/cmsapi/data1")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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

        Proxy::init()->getLogger()->addWarning(
            \GuzzleHttp\json_encode($unitList)
        );
        $content = 'Orders loaded';
        try {
            $response = (new Client())->process($unitList);
//            Output::echo($unitList);
//            Output::echo($response, true);
            (new Validator())->validateOrdersList($response);

            if (isset($response[0]->status) && $response[0]->status == 400) {
                $content = 'Error';
            } else {
                (new ResponseBuidser())->process($response);
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
     * @Route("/cmsapi/ordersqty")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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
        $lastTime = (new Loader())->loadLastUpdateTime();
        $lastId = (new Loader())->loadLastOrderId();
        try {
            $response = (new Client())->sendOrdersUpdateRequest(
                $lastTime->getOrdersUpdateLastDatetime(),
                $lastId->getOrdersUpdateLastId(),
                self::getRequest()
            );
            (new Validator())->validateOrdersList($response);
            if (isset($response[0]->status) && $response[0]->status == 400) {
                $content = 'Error';
            } else {
                $options = (new Process())->processUpdate($response);
                $lastTime->setOrdersUpdateLastDatetime($options[Api::UPDATE_TIME]);
                $lastId->setOrdersUpdateLastId($options[Api::LAST_ID]);
                Proxy::init()->getEntityManager()->persist($lastTime);
                Proxy::init()->getEntityManager()->flush();
            }
        } catch (MalformedResponseException $e) {
            $message = $e->getMessage();
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
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function isNotAuthMethod()
    {
        return (new Render())->render([
            Render::CONTENT => 'YES'
        ]);
    }

    /**
     * @Route("/api/v1/statusV2")
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
            (new RequestValidator())->validateNotBlank(
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
            $dateDiff =  $interval->format('%a');

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

        }

        Proxy::init()->getConnection()->close();

        return $this->success($ordersData);
    }

    /**
     * @Route("/api/v1/status")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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
            $loader = new Loader();
            if (!empty($inner)) {
                $order = $loader->loadOrderInner($innerId, $client);
            } else {
                $order = $loader->loadOrderId($orderId, $client);

            }
            if (!$order) {
                throw new \Exception('Order not found', 404);
            }

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
}