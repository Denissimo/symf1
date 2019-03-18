<?php

namespace App\Controller\Actions;

use App\Proxy;
use App\Cfg\Config;
use Symfony\Component\HttpFoundation\Request;

class Autorize
{
    const
        POST = 'POST',
        LOGOUT = 'logout',
        FIELD_LOGGED = 'logged',
        FIELD_USER_NAME = 'name',
        FIELD_ROLES = 'roles',
        FIELD_ACCESS = 'access',
        FIELD_UPIC = 'user_pick',
        FIELD_UID = 'uid';

    const
        ROLE_ADMIN = 'admin',
        ROLE_OPERATOR = 'operator',
        ROLE_OPERATOR4S = 'operator4s',
        ROLE_SUPERVISOR = 'supervisor';

    const
        ACCESS_USERLIST = 'userlist',
        ACCESS_ALL_APPS = 'all_apps',
        ACCESS_COMMAND_PROC = 'command_proc';


    private static $access = [
        self::ROLE_ADMIN => [self::ACCESS_USERLIST => true, self::ACCESS_COMMAND_PROC => true, self::ACCESS_ALL_APPS => true],
        self::ROLE_SUPERVISOR => [self::ACCESS_USERLIST => false, self::ACCESS_COMMAND_PROC => true, self::ACCESS_ALL_APPS => true],
        self::ROLE_OPERATOR4S => [self::ACCESS_USERLIST => true, self::ACCESS_COMMAND_PROC => false, self::ACCESS_ALL_APPS => false],
        self::ROLE_OPERATOR => [self::ACCESS_USERLIST => false, self::ACCESS_COMMAND_PROC => false, self::ACCESS_ALL_APPS => false]
    ];

    /**
     * @var \Users
     */
    private $user;

    /**
     * @param Request $request
     * @return bool
     */
    public function login(Request $request)
    {
        $config = Config::getAutorizeParams();
        /** @var \Users[] $users */
        $users = (array)Proxy::init()
            ->getEntityManager()
            ->getRepository($config[Config::FIELD_TABLE])
            ->findBy(
                [
                    Config::getDbUserField() => $request->get(Config::getRequestUserField()),
                    Config::getDbPassField() => sha1(
                        strtolower(
                            $request->get(Config::getRequestUserField()) . $request->get(Config::getRequestPassField())
                        )
                    )
                ]
            );
        /*
        Proxy::init()->getLogger()->addWarning(
            sha1(
                strtolower(
                    $request->get(Config::getRequestUserField()) . $request->get(Config::getRequestPassField())
                )
            )
        );
        */
        if (count($users)) {
            $this->user = $users[0];
            /** @var \Roles[] $roles */
            $roles = $this->user->getRole();
            Proxy::init()->getSession()->set(Config::FIELD_ROLES, implode(', ', $this->roleList($roles)));
            Proxy::init()->getSession()->set(Config::FIELD_ACCESS, $this->accessList($roles));
            Proxy::init()->getSession()->set(Config::FIELD_LOGIN, true);
            Proxy::init()->getSession()->set(Config::FIELD_USER, $this->user->getEmail());
            Proxy::init()->getSession()->set(Config::FIELD_NAME, $this->user->getName());
            Proxy::init()->getSession()->set(Config::FIELD_UID, $this->user->getId());
            Proxy::init()->getSession()->set(Config::FIELD_USERPIC, $this->user->getUserPic());
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function logout()
    {
        Proxy::init()->getSession()->set(Config::FIELD_LOGIN, false);
        Proxy::init()->getSession()->set(Config::FIELD_USER, null);
        Proxy::init()->getSession()->set(Config::FIELD_NAME, null);
        Proxy::init()->getSession()->set(Config::FIELD_UID, null);
        return true;
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_LOGIN);
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_NAME);
    }

    /**
     * @return string
     */
    public function getRolesList()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_ROLES);
    }

    /**
     * @return string
     */
    public function getUserPic()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_USERPIC) ?
            Proxy::init()->getSession()->get(Config::FIELD_USERPIC) :
            Config::getDefaults()[Config::FIELD_USERPIC][Config::FIELD_PATH] .
            Config::getDefaults()[Config::FIELD_USERPIC][Config::FIELD_NAME];
    }


    public function setUserPick(string $userpick) {
        Proxy::init()->getSession()->set(Config::FIELD_USERPIC, $userpick);
        return true;
    }

    /**
     * @return array
     */
    public function getAccessList()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_ACCESS);
    }
    /**
     * @return int
     */
    public function getUserId()
    {
        return Proxy::init()->getSession()->get(Config::FIELD_UID);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isUriGranted(Request $request)
    {
        return in_array(
            $request->getRequestUri(),
            Config::getGrantedUris()
        );
    }

    /**
     * @param Request $request
     */
    public function autorize(Request $request)
    {
        if ($request->getMethod() == self::POST && $request->get(Config::getRequestUserField())) {
            (new Autorize())->login($request);
        }

        if ($request->getMethod() == self::POST && $request->get(self::LOGOUT)) {
            (new Autorize())->logout();
        }
    }

    /**
 * @param \Roles[] $roles
 * @return array
 */
    private function accessList($roles)
    {
        $access = [self::ACCESS_USERLIST => false, self::ACCESS_COMMAND_PROC => false, self::ACCESS_ALL_APPS => false];
        foreach ($roles as $role) {
            $roleAccess = self::$access[$role->getName()];
            foreach ($roleAccess as $key => $val) {
                $access[$key] = $access[$key] ? $access[$key] : $val;
            }
        }
        return $access;
    }

    /**
     * @param \Roles[] $roles
     * @return array
     */
    private function roleList($roles)
    {
        $roleList = [];
        foreach ($roles as $role) {
            $roleList[] = $role->getName();
        }
        return $roleList;
    }
}