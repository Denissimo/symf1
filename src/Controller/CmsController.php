<?php

namespace App\Controller;

use App\Controller\Api\Client;
use App\Controller\Api\Request\Unit;
use App\Exceptions\BadResponseException;
use App\Exceptions\OrdersListEmptyResponseException;
use http\Env\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Twig\Render;
use App\Controller\Api\Fields as Api;
use App\Controller\Api\Loader;
use App\Controller\Api\Request\Builder;
use App\Controller\Api\Response\Builder as ResponseBuidser;
use App\Controller\Api\Response\Validator;
use App\Exceptions\MalformedResponseException;

class CmsController extends BaseController implements Api
{
    //@Route("/cmsapi/orders")


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
        if(isset($get[Api::CLIENT_ID])){
            $orderStat = (new Loader())->loadClientsJoinOrders($get[Api::CLIENT_ID]);
            if(count($orderStat)) {
                $unitList[] = (new Unit())->set($orderStat[0], $get);
            } else {
                die('Все ордера загружены');
            }
        } else {
            $orderStat = (new Loader())->loadClientsJoinOrders();
//            var_dump($orderStat); die;
            /** @var Unit[] $unitList */
            $unitList = (new Builder())->set(
                $orderStat,
                self::getRequest()
            )->getUnitlist();
        }
//        echo "<pre>";  var_dump($unitList);  die;
        Proxy::init()->getLogger()->addWarning(
            \GuzzleHttp\json_encode($unitList)
        );
        $content = 'Orders loaded';
        try {
//            echo "<pre>";
//            var_dump($unitList);
//            die;
            $response = (new Client())->process($unitList);
//            $response = [1, 2, 3];
            //var_dump($response[0]->status); die;
//            echo "<pre>"; var_dump($response); die;
            (new Validator())->validateOrdersList($response);
            if(isset($response[0]->status)) {
                $content = 'Error';
            } else {
                (new ResponseBuidser())->process($response);
            }
        } catch (MalformedResponseException $e) {
            $content = $e->getMessage();
        } catch (OrdersListEmptyResponseException $e) {
            $content = $e->getMessage();
        }

        return (new Render())->render([
            Render::CONTENT =>  $content
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

        return (new Render())->render([
            Render::CONTENT => $message
        ]);
    }

}