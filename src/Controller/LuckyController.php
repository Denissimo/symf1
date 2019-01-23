<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
     /**
      * @Route("/lucky/number")
      */
    public function number()
    {
        echo ".kjg,kg";
    }
}