<?php

namespace App\Api\Request;

use App\Proxy;
use Symfony\Component\Validator\Constraints as Assert;
use App\Exceptions\MalformedRequestException;
use App\Api\Fields as Api;
use Symfony\Component\HttpFoundation\Request;

class Validator
{
    const
        RESPONSE = 'response';
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

    /**
     * @param $object
     * @param $errorMessage
     */
    public function validateNotBlank($object, $errorMessage)
    {
        Proxy::init()->getValidator()->validateType(
            [self::RESPONSE => $object],
            [
                self::RESPONSE => new Assert\NotBlank()
            ],
            $errorMessage,
            MalformedRequestException::class
        );
    }

    /**
     * @param int $diff
     * @param int $days
     */
    public function validateDateDiff($diff, $days)
    {
        Proxy::init()->getValidator()->validate(
            $diff,
            new Assert\LessThan($days),
            'Date interval over '. $days . ' days',
            MalformedRequestException::class
        );
    }

}