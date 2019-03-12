<?php

namespace App\Controller\Api\Request;

use App\Proxy;
use Symfony\Component\Validator\Constraints as Assert;
use App\Exceptions\MalformedRequestException;
use App\Controller\Api\Fields as Api;
use Symfony\Component\HttpFoundation\Request;

class Validator
{
    /**
     * @param $ordersList
     */
    public function validateStatusV3Request(Request $Request)
    {
        $requiredFields = [
            Api::FIELD_FROM,
            Api::FIELD_TO,
            Api::KEY
        ];
        Proxy::init()->getValidator()->validateRequired(
            $Request->query->all(),
            $requiredFields,
            'Fields ' . implode(', ', $requiredFields) . ' are REQUIRED !!!',
            MalformedRequestException::class
        );
    }


}