<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Twig\Render;
use App\Controller\Api\Fields as Api;
use App\Controller\Api\Loader;

class CmsController extends BaseController implements Api
{

    /**
     * @Route("/cmsapi/orders")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function loadOrders()
    {

        $c = (new Loader())->loadClients()->getClientId();
        Proxy::init()->getLogger()->addWarning(
//            \GuzzleHttp\json_encode(self::getRequest()->query->all())
            $c
        );
        return (new Render())->render([
//            Render::CONTENT => \GuzzleHttp\json_encode((self::getRequest())->query->all())
            Render::CONTENT => $c
        ]);
    }



}