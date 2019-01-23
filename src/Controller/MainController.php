<?php

namespace App\Controller;

use App\Exceptions\DefaultException;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Actions\Autorize;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Twig\Render;
use App\Cfg\Config;
use App\Validator;
use App\Controller\Criteria\Builder;
use Doctrine\Common\Collections\Criteria;
use App\Controller\Query\Builder as Qb;
use Monolog\Logger;


class MainController extends BaseController
{

    /**
     * @Route("/", name="home")
     * @return Response
     * @throws \Exception
     */
    public function home()
    {
        $data['login'] = self::getRequest()->headers->get('referer');
        $data['number'] = random_int(0, 100);
        $data['post'] = self::getRequest()->getMethod();
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        return (new Render())->render($data);
    }


}