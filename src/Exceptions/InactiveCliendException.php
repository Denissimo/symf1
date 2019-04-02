<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class InactiveCliendException extends \Exception
{
    const ERROR_CODE = HttpResponse::HTTP_METHOD_NOT_ALLOWED;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, static::ERROR_CODE, $previous);
    }
}