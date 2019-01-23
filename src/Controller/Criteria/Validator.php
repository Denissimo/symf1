<?php

namespace App\Controller\Criteria;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use App\Proxy;


class Validator
{
    private static $allowedFields = [
        'partner_id',
         'foreign_id',
         'user_id',
         'status',
         'createdAt',
         'updatedAt'
    ];

    public function validateRequest(Request $request)
    {

    }
}