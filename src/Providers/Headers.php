<?php

namespace App\Providers;


use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;

class Headers extends Request
{
    protected $user = null;

    public function initialize(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::initialize($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->headers = new HeaderBag(array_merge($this->server->getHeaders(), getallheaders()));
    }
}