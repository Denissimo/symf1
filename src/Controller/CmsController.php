<?php

namespace App\Controller;

use App\Controller\Api\Client;
use App\Controller\Api\Request\Unit;
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
        if($get[Api::CLIENT_ID]){
            $unitList[] = (new Unit())
                ->set($get, $get);
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

        try {
//            echo "<pre>";
//            var_dump($unitList);
//            die;
            $response = (new Client())->process($unitList);
//            $response = [1, 2, 3];
            (new Validator())->validateOrdersList($response);

//            echo "<pre>";
//            var_dump($response);
//            var_dump(\DateTime::createFromFormat('h:i',$response[0]->delivery_time2));
//            var_dump(\DateTime::createFromFormat('h:i',$response[1]->delivery_time2));
//            die;
            (new ResponseBuidser())->process($response);
        } catch (MalformedResponseException $e) {
            var_dump($e->getMessage());
            die;
        }
        echo "<br /><br />ZZZZZZ<br />";
        die;


        return (new Render())->render([
            Render::CONTENT => \GuzzleHttp\json_encode($response)
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