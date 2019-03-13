<?php

namespace App\Controller;

use App\Providers\Headers;
use App\Proxy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function getUser()
    {
        return Proxy::init()->getSession()->get(self::USER_MODEL);
    }

}