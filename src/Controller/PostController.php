<?php

namespace App\Controller;

use App\Exceptions\DefaultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Cfg\Config;
use Symfony\Component\HttpFoundation\Request;
use App\Api\Actions\Autorize;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\Criteria;
use App\Twig\Render;
use App\Validator;
use Monolog\Logger;
use Symfony\Component\Security\Core\Authentication;

class PostController extends BaseController
{

    /**
     * @Route("addupic", name="addupic")
     * @return RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addUpic()
    {
        /** @var UploadedFile $file */
        $file = current(self::getRequest()->files->all());

        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        try {
            $file->move($this->get('kernel')->getProjectDir() .
                Config::getDefaults()[Config::FIELD_USERPIC][Config::FIELD_UPLOAD], $fileName
            );
//            $a = $file->move('\images\userpics', $fileName);
        } catch (\Exception $e) {
            return $this->redirect(
                self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
            );
        }

        /** @var \Users $user */
        $user = Proxy::init()->getEntityManager()->getRepository(\Users::class)->find(
            (new Autorize())->getUserId()
        );
        $user->setUserPic($fileName);
        Proxy::init()->getEntityManager()->flush();
        (new Autorize())->setUserPick($user->getUserPic());

        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );
    }


    /**
     * @Route("edituser", name="edituser")
     * @return RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editUser()
    {
        /** @var \Users $user */
        $user = Proxy::init()->getEntityManager()->getRepository(\Users::class)->find(
            self::getRequest()->get(\Users::ID)
        );
        $user->setName(self::getRequest()->get(\Users::NAME))
            ->setEmail(self::getRequest()->get(\Users::EMAIL))
            ->setEnabled(
                self::getRequest()->get(\Users::ENABLED) ? true : false
            )
            ->setPriority(
                self::getRequest()->get(\Users::PRIORITY)
            );
        if (self::getRequest()->get(\Users::PASSWORD)) {
            $user->setPassword(
                sha1(
                    strtolower(
                        self::getRequest()->get(\Users::EMAIL) . self::getRequest()->get(\Users::PASSWORD)
                    )
                )
            );
        }

        Proxy::init()->getEntityManager()->flush();
        return $this->redirect(
            $this->generateUrl('users')
        );
    }

    /**
     * @Route("autorize", name="autorize")
     * @return RedirectResponse
     */
    public function autorize()
    {
        (new Autorize())->autorize(self::getRequest());
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );

    }

    /**
     * @Route("login", name="login")
     * @return RedirectResponse
     */
    public function login()
    {
        (new Autorize())->autorize(self::getRequest());
        return $this->redirect(
            self::getRequest()->headers->get('referer') ?? $this->generateUrl('main')
        );

    }
}