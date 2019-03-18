<?php

namespace App\Api\Response;

use App\Proxy;
use Symfony\Component\Validator\Constraints as Assert;
use App\Exceptions\MalformedResponseException;
use App\Exceptions\BadResponseException;

class Validator
{
    const
        RESPONSE = 'response';

    /**
     * @param $ordersList
     */
    public function validateOrdersList($ordersList)
    {
        Proxy::init()->getValidator()->validateType(
            [self::RESPONSE => $ordersList],
            [
                self::RESPONSE => new Assert\Type(
                    ['type' => 'array']
                )
            ],
            'Orders list is not an Array',
            MalformedResponseException::class
        );
    }



}