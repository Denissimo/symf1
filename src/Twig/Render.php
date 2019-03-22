<?php

namespace App\Twig;

use App\Proxy;
use App\Cfg\Config;
use App\Api\Actions\Autorize;
use Symfony\Component\HttpFoundation\Response;


class Render
{

    const CONTENT = 'content';

    /**
     * @param array $data
     * @param string|null $template
     * @param int $status
     * @param array $headers
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(array $data, string $template = null, $status = Response::HTTP_OK, $headers = [])
    {
        $data[Autorize::FIELD_LOGGED] = (new Autorize())->isLogged();
        $data[Autorize::FIELD_USER_NAME] = (new Autorize())->getUserName();
        $data[Autorize::FIELD_ROLES] = (new Autorize())->getRolesList();
        $data[Autorize::FIELD_ACCESS] = (new Autorize())->getAccessList();
        $data[Autorize::ACCESS_COMMAND_PROC] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        $data[Autorize::FIELD_UID] = (new Autorize())->getUserId();
        $data[Autorize::FIELD_UPIC] = (new Autorize())->getUserPic();
        $tpl = $template ?? Config::getTwigDefaultTemplate();
        /*
        if(Config::isAutorizeObligatory() && !(new Autorize())->isLogged()){
            $tpl = Config::getTwigLoginTemplate();
        } else {
            $tpl = $template ?? Config::getTwigDefaultTemplate();
        }
        */
        return new Response(
            Proxy::init()->getTwigEnvironment()->render(
                $tpl,
                $data
            ),
            $status,
            $headers
        );
    }

    /**
     * @param array $data
     * @param string|null $template
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function simpleRender(array $data, string $template = null)
    {
        $data[Autorize::FIELD_LOGGED] = (new Autorize())->isLogged();
        $tpl = $template ?? Config::getTwigDefaultTemplate();
        return new Response(
            Proxy::init()->getTwigEnvironment()->render(
                $tpl,
                $data
            )
        );
    }
}