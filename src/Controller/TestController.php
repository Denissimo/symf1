<?php

namespace App\Controller;

use App\Kernel;
use App\Security\AuthListener;
use Doctrine\ORM\Mapping\EntityResult;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Controller\Forms\FormBuilder;
use Users;
use App\Twig\Render;
use App\Controller\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use App\Cfg\Config;

class TestController extends BaseController
{


    /**
     * @Route("/admin")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function admin()
    {
        try{
            return (new Render())->render([
                'data' => ' try'
            ]);
        } catch (\Exception $e){
            return (new Render())->render([
                'data' => $e->getMessage()
            ]);
        }

//        return (new Render())->render([
//            'data' => ' admin'
//        ]);
    }
    /**
     * @Route("/secur")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function secur()
    {
        Proxy::init()->getLogger()->addWarning(
            \GuzzleHttp\json_encode(self::getRequest())
        );
        return (new Render())->render([
            'data' => \GuzzleHttp\json_encode(self::getRequest())
        ]);
    }



}