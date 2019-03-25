<?php

namespace App\Exceptions;


class ErrorApiKey extends DefaultException
{
    protected $code = 401;
}