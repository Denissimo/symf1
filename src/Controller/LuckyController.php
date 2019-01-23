<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function home()
    {
        return new Response(
            '<html><body>Lucky number: '.rand(999, 9999).'</body></html>'
        );
    }

    /**
     * @Route("/asdf", name="asdf")
     * @return Response
     */
    public function asdf()
    {
        return new Response(
            '<html><body>Lucky number: asdf</body></html>'
        );
    }

}