<?php

namespace App\Security;

use App\Controller\BaseController;
use App\Providers\Headers;
use App\Proxy;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthorizationUserProvider extends AbstractGuardAuthenticator
{
    const TOKEN_KEY = 'Authorization';

    protected $request;

    public function __construct(Headers $request)
    {
        $this->request = $request;
    }

    /**
     * Проверяет нужно ли использовать этот провайдер
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->headers->has(self::TOKEN_KEY);
    }

    /**
     * вернет индификатор пользователя - токен
     *
     * @param Request $request
     * @return mixed|string|string[]|null
     */
    public function getCredentials(Request $request)
    {
        $header = $request->headers->get(self::TOKEN_KEY);
        list($type, $token) = explode(' ', $header);
        return trim($token);
    }

    /**
     * поднимаем пользователя из базы
     *
     * @param mixed $token
     * @param UserProviderInterface $userProvider
     * @return UserInterface|\Users|null
     */
    public function getUser($token, UserProviderInterface $userProvider)
    {
        /**
         * @TODO поднимаем пользователя из базы
         */
        $user = new \Users();
        $user->setName(uniqid('user_'));

        Proxy::init()->getSession()->set(BaseController::USER_MODEL, $user);
        return $user;
    }

    /**
     * Валидируем пользователя
     *
     * @param mixed $token
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($token, UserInterface $user)
    {
        $demoToken = 'VALIDATE_TOKEN';
        if ($demoToken !== $token) {
            return false;
        }
        return true;
    }

    /**
     * Авторизация успешна
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * ошибка авторизации
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            // you might translate this message
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }

}