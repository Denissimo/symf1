<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class MalformedApiKeyException extends \Exception
{
    const ERROR_CODE = HttpResponse::HTTP_UNAUTHORIZED;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, static::ERROR_CODE, $previous);
    }
}