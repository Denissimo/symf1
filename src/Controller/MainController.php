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
use App\Controller\Apps\Builder as AppBuilder;
use App\Controller\Apps\Sorter;
use App\Controller\Query\Builder as Qb;
use App\Params\Params;
use Monolog\Logger;


class MainController extends BaseController
{

    /**
     * @var \Apps
     */
    private $unit;

    private $s;

    /**
     * LuckyController constructor.
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @Route("/", name="main")
     * @return Response
     * @throws \Exception
     */
    public function main()
    {
        $data['login'] = self::getRequest()->headers->get('referer');
        $data['number'] = random_int(0, 100);
        $data['post'] = self::getRequest()->getMethod();
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        return (new Render())->render($data);
    }


    /**
     * @Route("apps", name="apps")
     * @return Response
     */
    public function apps()
    {

//        Proxy::init()->getLogger()->addWarning(
//            \GuzzleHttp\json_encode(
//                $app->getUser()->getName()
//            )
//        );

        return (new Render())->render($data, 'appstable.html.twig');
    }
}