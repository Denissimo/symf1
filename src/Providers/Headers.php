<?php

namespace App\Providers;


use App\Exceptions\ErrorApiKey;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use App\Proxy;
use App\Api\Fields;

class Headers extends Request
{
    protected $user = null;

    public function initialize(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::initialize($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->headers = new HeaderBag(array_merge($this->server->getHeaders(), getallheaders()));
    }

    /**
     * Вернет api key
     *
     * @throws ErrorApiKey
     * @return string
     */
    public function getApiKey()
    {
        $param = array_merge($this->query->all(), $this->request->all());
<<<<<<< HEAD

        if (!isset($param[Fields::KEY])) {
            throw new ErrorApiKey('Поле "' . Fields::KEY . '" обязательно!');
=======
        if (!$param[Fields::KEY]) {
            throw new ErrorApiKey('Fields "' . Fields::KEY . '" are REQUIRED !!!');
>>>>>>> step 3
        }

        return $param[Fields::KEY];
    }
}