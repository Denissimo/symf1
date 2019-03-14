<?php

namespace App\Exceptions;


class ErrorApiKey extends \Exception
{
    protected $code = 401;
}