<?php

namespace App\Controller;

use App\Kernel;
use App\Security\AuthListener;
use Doctrine\ORM\Mapping\EntityResult;
use http\Header;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Controller\Forms\FormBuilder;
use Users;
use Goods;
use App\Twig\Render;
use App\Controller\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use App\Cfg\Config;
use Doctrine\Common\Collections\Criteria;
use GuzzleHttp\Client;



class TestController extends BaseController
{


    /**
     * @Route("/admin")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function admin()
    {
        try {
            return (new Render())->render([
                Render::CONTENT => ' try'
            ]);
        } catch (\Exception $e) {
            return (new Render())->render([
                Render::CONTENT => $e->getMessage()
            ]);
        }

//        return (new Render())->render([
//            Render::CONTENT => ' admin'
//        ]);
    }

    /**
     * @Route("/secur")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function secur()
    {
        Proxy::init()->getLogger()->addWarning(
            \GuzzleHttp\json_encode(self::getRequest())
        );
        return (new Render())->render([
            Render::CONTENT => \GuzzleHttp\json_encode((self::getRequest())->query->all())
        ]);
    }

    /**
     * @Route("/sql")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sql()
    {
        $qb = Proxy::init()->getEntityManager()->createQueryBuilder();
        $res = $qb
            ->select('g.id', 'g.article', 'g.orderId')
            ->from('Goods', 'g')
//            ->where('a.userId=9')
            ->setMaxResults(5)
            ->getQuery()
            ->execute();
        $data[Render::CONTENT] = \GuzzleHttp\json_encode($res);
        return (new Render())->render($data, 'test.html.twig');
    }

    /**
     * @Route("/jpeg")
     * @return Response
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function jpeg()
    {
        $attachment3 = file_get_contents('C:\OSpanel\OSPanel\domains\symf1\public\images\suda.jpeg');
        $attachment_encoded3 = base64_encode($attachment3);
        \header("Content-type: text/plain");
//        \header("Content-type: image/jpeg");
        echo $this->oord($attachment3);
//        echo $attachment3;
        die;
        $data[Render::CONTENT] = $this->oord($attachment3);
//        $data[Render::CONTENT] = $attachment_encoded3;
//        $data[Render::CONTENT] = $attachment3;
        return (new Render())->render(
            $data,
            'jpeg.html.twig',
            Response::HTTP_OK,
            ["Content-type" => "text/plain"]
//            ["Content-type" => "image/jpeg"]
        );
    }

    /**
     * @param string $str
     * @return array
     */
    private function oord(string $str)
    {
        $len = mb_strlen($str);
        for($i = 0; $i< $len; $i++){
            $res[] = ord($str[$i]);
        }
//        return \GuzzleHttp\json_encode($res);
        return implode("\r\n", $res);
    }


    /**
     * @Route("/sql1")
     * @return Response
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sql1()
    {
        $query = "SELECT * FROM goods WHERE goods_status = 4 AND price > 20.0 LIMIT 5";
        $sth = Proxy::init()->getConnecton()->query($query);
        $sth->bindValue(':status', 4);
        $sth->bindValue(':price', 20.0);
        $sth->execute();
        $res = $sth->fetchAll();

        $data[Render::CONTENT] = \GuzzleHttp\json_encode($res);
        return (new Render())->render($data, 'test.html.twig');
    }

    /**
     * @Route("/sql2")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sql2()
    {
        $qb = Proxy::init()->getEntityManager()->createQueryBuilder();
        /** @var Users[] $res */
        $res = $qb->select('u')
            ->from(\Users::class, 'u')
            ->getQuery()
            ->execute();

        $data[Render::CONTENT] = \GuzzleHttp\json_encode($res[0]->getEmail());
        return (new Render())->render($data, 'test.html.twig');
    }

    /**
     * @Route("/sql3")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sql3()
    {
        /** @var Goods[] $res */
        $res = Proxy::init()->getEntityManager()->getRepository(\Goods::class)->findAll();
        $data[Render::CONTENT] = \GuzzleHttp\json_encode($res[0]->getDescription());
        return (new Render())->render($data);
    }

    /**
     * @Route("/testpost")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testpost()
    {
        $request = self::getRequest()->request->all();
        $data[Render::CONTENT] = \GuzzleHttp\json_encode($request);
        return (new Render())->render($data, 'test.html.twig');
    }

    //xxxxxxxxxxxxxxxxxxxxxxx

    /**
     * @Route("/zorders")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function zorders()
    {
        /** @var \Zorders[] $res */
        $res = Proxy::init()->getEntityManager()
            ->getRepository(\Zorders::class)
            ->matching(
                Criteria::create()
                    ->orderBy(['id' => 'ASC'])
                    ->setMaxResults(1)

            )->toArray();
//        var_dump($res); die;
//        $data[Render::CONTENT] = \GuzzleHttp\json_encode($res[0]->getSklad()->getAddr());
        $data[Render::CONTENT] = $res[0]->getSklad()->getAddr();
        return (new Render())->render($data);
    }

    /**
     * @Route("/test")
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function test()
    {

        Proxy::init()->initDoctrine();


        /** @var \Users[] $user */
        $user = Proxy::init()->getEntityManager()
            ->getRepository(\Users::class)
            ->findBy(['name' => 'Den Drake']);

//        var_dump($user); die;
//        $user[0]->setName('ZZdddzz');
//        Proxy::init()->getEntityManager()->flush();

        /*
        $newUser = (new Users())
            ->setName('sdfgag')
            ->setEmail('ss@xhx.xx')
            ->setPassword('kjhgfkjfkfku')
            ->setEnabled(true)
        ;
        */

//        Proxy::init()->getEntityManager()->persist($newUser);
//        Proxy::init()->getEntityManager()->flush();


//        Proxy::init()->getLogger()->addWarning(
//            \GuzzleHttp\json_encode(
//                $app->getUser()->getName()
//            )
//        );
//

        /*
                $query = 'INSERT INTO comments SET app_id = :app_id, comment = :comment, uid = :user_id, ts = now(), reminder = :reminder, ctype = :ctype;';
                $sth = Proxy::init()->getConnecton()->prepare($query);
                $sth->bindValue(':app_id', (int)self::getRequest()->get('app_id'), \PDO::PARAM_INT);
                $sth->bindValue(':user_id', (int)self::getRequest()->get('user_id'), \PDO::PARAM_INT);
                $sth->bindValue(':ctype', $ctype, \PDO::PARAM_INT);
                $sth->bindValue(':comment', self::getRequest()->get('comment'), \PDO::PARAM_STR);
                $sth->bindValue(':reminder', $reminderStr);
                $sth->execute();
        */
        $data[Render::CONTENT] = 'zdf';
        $data['form'] = (new FormBuilder())->buildForm()->createView();
        return (new Render())->render($data, 'test.html.twig');
    }

    /**
     * @Route("/swag1")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function swag()
    {
        $data[Render::CONTENT] = 'sss';
        return (new Render())->render($data);
    }
}