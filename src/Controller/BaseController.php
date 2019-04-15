<?php

namespace App\Controller;

use App\Exceptions\DeactivateApiKey;
use App\Exceptions\ErrorApiKey;
use App\Providers\Headers;
use App\Proxy;
use App\Twig\Render;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\Request\Validator;


abstract class BaseController extends AbstractController
{

    const USER_MODEL = 'user_model';

    const
        ADD_COMMENT = 'addcomment',
        FROM = '_from',
        TO = '_to',
        APP_ID = 'app_id',
        COMMENT = 'comment',
        APP = 'app',
        USERS = 'users',
        USER = 'user',
        USER_ROLES = 'user_roles',
        LIST_ROLES = 'list_roles',
        ROLES = 'roles',
        CREATE_FROM = 'create_from',
        CREATE_TO = 'create_to',
        CREATE_AT = 'createdat',
        UPDATE_FROM = 'update_from',
        UPDATE_TO = 'update_to',
        UPDATE_AT = 'updatedat',
        USER_ID = 'userId',
        PARTNER_ID = 'partnerId',
        PER_PAGE = 'per_page',
        DEFAULT_LIMIT = 50,
        SORT = 'sort',
        LIMIT = 'limit';


    public static $fields = [
        self::CREATE_AT => [self::FROM => self::CREATE_FROM, self::TO => self::CREATE_TO],
        self::UPDATE_AT => [self::FROM => self::UPDATE_FROM, self::TO => self::UPDATE_TO]
    ];


    /**
     * @var Headers
     */
    private static $request;

    /**
     * BaseController constructor.
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct()
    {
        self::$request = Headers::createFromGlobals();
    }

    /**
     * @return Headers
     */
    public static function getRequest(): Headers
    {
        return self::$request;
    }

    /**
     * @return mixed|\Users
     */
    protected function getUser()
    {
        return Proxy::init()->getSession()->get(self::USER_MODEL);
    }


    /**
     * Вернет объект ClientSettings на основе переданного api key
     *
     * @return \ClientSettings|null|object
     * @throws DeactivateApiKey
     * @throws ErrorApiKey
     */
    protected function getClientSettings()
    {
        /** @var \ClientSettings $clientSettings */
        $clientSettings = \ClientSettings::getRepository()
            ->findOneBy([\ClientSettings::API_KEY => self::getRequest()->getApiKey()]);

        if (!$clientSettings) {
            throw new ErrorApiKey('Ошибка: неверный apikey', 401);
        }
        if (!$clientSettings->getActive()) {
            throw new ErrorApiKey('ApiKey не активен', 405);
        }
        return $clientSettings;
    }

    /**
     * Рендер ошибки
     * @param \Exception $e
     * @param int $code
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function error(\Exception $e, $code = Response::HTTP_BAD_REQUEST)
    {
        $code = $e->getCode() ? $e->getCode() : $code;
        return $this->prepareResult($e, [], $code);
    }

    /**
     * рендер
     * @param $content
     * @param array $customOptions
     * @param int $code
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function success($content, array $customOptions = [], $code = Response::HTTP_OK)
    {
        return $this->prepareResult($content, $customOptions, $code);
    }

    /**
     * @param $content
     * @param array $customOptions
     * @param int $code
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function prepareResult($content, $customOptions = [], $code = Response::HTTP_OK)
    {
        Proxy::init()->getConnection()->close();
        if ($content instanceof \Exception) {
            $response = [
                'Error' => $content->getMessage()
            ];
        } else {
            $response = $content;
        }

        return $this->printJson(\GuzzleHttp\json_encode(array_merge([
            'status' => $code,
            'response' => $response
        ], $customOptions)), $code);
    }

    /**
     * @param $content
     * @param $code
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function printJson($content, $code): Response
    {
        $headers = [
            'Content-Type' => 'application/json',
            'charset' => 'utf-8',
//            'Access-Control-Allow-Origin' => 'http://editor.swagger.io',
            'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept'
        ];
        return (new Render())->render(
            [Render::CONTENT => $content],
            'empty.html.twig',
            $code,
            $headers
        );
    }

}