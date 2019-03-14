<?php
/**
 * Created by PhpStorm.
 * User: drnemo
 * Date: 13.03.19
 * Time: 13:15
 */

namespace App\Exceptions;


class ErrorApiKey extends \Exception
{
    protected $code = 401;
}