<?php

namespace App\Api\Request;

use App\Exceptions\InactiveCliendException;
use App\Exceptions\MalformedApiKeyException;
use App\Proxy;
use Symfony\Component\Validator\Constraints as Assert;
use App\Exceptions\MalformedRequestException;
use App\Api\Fields as Api;
use Symfony\Component\HttpFoundation\Request;

class Validator
{
    const
        DATA = 'data';

    /**
     * @param Request $Request
     * @param array $requiredFields
     */
    public function validateRequiredFields(Request $Request, array $requiredFields)
    {

        Proxy::init()->getValidator()->validateRequired(
            $Request->query->all(),
            $requiredFields,
            'Required fields missing: ' . implode(', ', $requiredFields),
            MalformedRequestException::class
        );
    }


    public function validateClientActive(\ClientSettings $client)
    {
        Proxy::init()->getValidator()->validateType(
            [self::DATA => $client->getActive()],
            [
                self::DATA => new Assert\EqualTo(\ClientSettings::VALUE_ACTIVE)
            ],
            'Inactive cletnt !',
            InactiveCliendException::class
        );
    }

    /**
 * @param $object
 * @param $errorMessage
 */
    public function validateNotBlank($object, $errorMessage)
    {
        Proxy::init()->getValidator()->validateType(
            [self::DATA => $object],
            [
                self::DATA => new Assert\NotBlank()
            ],
            $errorMessage,
            MalformedRequestException::class
        );
    }


    /**
     * @param $object
     * @param $errorMessage
     */
    public function validateApiKey($object, $errorMessage)
    {
        Proxy::init()->getValidator()->validateType(
            [self::DATA => $object],
            [
                self::DATA => new Assert\NotBlank()
            ],
            $errorMessage,
            MalformedApiKeyException::class
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