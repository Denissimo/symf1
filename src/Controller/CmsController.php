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
        $clentIds = (array)($get[self::CLIENT_ID] ?? (new Loader())->loadClientsJoinOrders());
        /** @var Unit[] $unitList */
        $unitList = (new Builder())->set(
            $clentIds,
            self::getRequest()
        )->getUnitlist();

        Proxy::init()->getLogger()->addWarning(
            \GuzzleHttp\json_encode($unitList)
        );

        try {
            $response = (new Client())->process($unitList);
//            $response = [1, 2, 3];
            (new Validator())->validateOrdersList($response);

//            echo "<pre>";
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


}