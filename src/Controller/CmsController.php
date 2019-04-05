<?php

namespace App\Controller;

use App\Api\Client;
use App\Api\Request\Unit;
use App\Exceptions\BadResponseException;
use App\Exceptions\InvalidRequestAgrs;
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
     * @return HttpResponse
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
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
            (new Validator())->validateResponseList($response);

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
    private function compareOptionsLastUpdateTime(\DateTime $current, \Options $lastTime)
    {
        $checkTime = (new \DateTime())->sub(
            new \DateInterval(Api::MAX_LOAD_UPDATE_INTERVAL)
        );
        if ($current > $checkTime) {
            $lastTime->setUpdateLastDatetime($current);
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
            (new Validator())->validateResponseList($response);
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
                $lastTime->getUpdateLastDatetime(),
                $useId->getValue() ? $lastId->getValue() : Api::ZERO,
                (new Loader())->loadBiggestOldId(),
                self::getRequest()
            );
            (new Validator())->validateResponseList($response);
            if (isset($response->status) && $response->status == 400) {
                $content = 'Error';
                Proxy::init()->getLogger()->addWarning('Error: ' . $content);
            } else {
                $options = (new Process())->processUpdate($response);
                $lastTime->setUpdateLastDatetime($options[\Options::ORDERS_UPDATE]);
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
            Render::CONTENT => $lastTime->getUpdateLastDatetime()->format('c')
        ]);
    }

    /**
     * @Route("/cmsapi/pordersupdate")
     * @return HttpResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function loadPordersUpdate(){
        $lastTime = (new Loader())->loadOption(\Options::PORDERS_UPDATE);
        $lastId = (new Loader())->loadOption(\Options::PORDERS_LAST_ID);
        $useId = (new Loader())->loadOption(\Options::PORDERS_USE_ID);
        try {
            $response = (new Client())->sendPordersUpdateRequest(
                $lastTime->getUpdateLastDatetime(),
                self::getRequest(),
                $useId->getValue() ? $lastId->getValue() : Api::ZERO
            );
            (new Validator())->validateResponseList($response);
            if (isset($response->status) && $response->status == 400) {
                $content = 'Error';
                Proxy::init()->getLogger()->addWarning('Error: ' . $content);
            } else {
                $options = (new Process())->saveUpdatePorders($response);
                $lastTime->setUpdateLastDatetime($options[\Options::PORDERS_UPDATE]);
                $lastId->setValue($options[\Options::PORDERS_LAST_ID]);
                $useId->setValue($options[\Options::PORDERS_USE_ID]);
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
        return (new Render())->render([
            Render::CONTENT => $lastTime->getUpdateLastDatetime()->format('c')
        ]);
    }

    /**
     * @Route("/cmsapi/listsupdate")
     * @return HttpResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function loadListsUpdate()
    {

        $content = null;
        $updatedStock = (new Loader())->loadLastStockUpdated();
        try {
            $response = (new Client())->sendListsUpdateRequest($updatedStock);

//            (new Validator())->validateOrdersList($response->clients);

            if (isset($response->status) && $response->status == 400) {
                $content = 'Error';
                Proxy::init()->getLogger()->addWarning('UpdateListError: ' . $content);
            } else {
                $result = (new Process())->processLists($response);

                $content = 'OK';
            }
        } catch (MalformedResponseException $e) {
            $message = $e->getMessage();
            Proxy::init()->getLogger()->addWarning('MalformedResponseException: ' . $e->getMessage());
        } catch (\Exception $e) {
            Proxy::init()->getLogger()->addWarning('Exception: ' . $e->getMessage());
        }
        return (new Render())->render([
            Render::CONTENT => $content
        ]);
    }
}