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
use Users;
use Goods;
use App\Twig\Render;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use App\Cfg\Config;
use Doctrine\Common\Collections\Criteria;
use GuzzleHttp\Client;
use App\Api\Loader;

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
        for ($i = 0; $i < $len; $i++) {
            $res[] = ord($str[$i]);
        }
//        return \GuzzleHttp\json_encode($res);
        return implode("\r\n", $res);
    }

    /**
     * @Route("/clset")
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function clset()
    {
        $order = (new Loader())->loadOrderByOid(1);
        /** @var \ClientSettings $cs */
        $cs = Proxy::init()->getEntityManager()->getRepository(\ClientSettings::class)->find(3);

        /** @var \Orders $ord */
        $ord = Proxy::init()->getEntityManager()->getRepository(\Orders::class)->find(1);
//        echo '<pre>'; var_dump($res); die();
        $data[Render::CONTENT] = is_object($order). ' >> '; // . \GuzzleHttp\json_encode($order->getOldId());
        return (new Render())->render($data, 'test.html.twig');
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
        $sth = Proxy::init()->getConnection()->query($query);
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
     * @Route("/latlong")
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function latlong()
    {
        /** @var \Address[] $addresss */
        $address = Proxy::init()->getEntityManager()->getRepository(\Address::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->andX(
                            Criteria::expr()->isNull('latitude'),
                            Criteria::expr()->neq('latlong', null)
                        )

                    )
                    ->setMaxResults(5000)
            );
        $content = '';
        foreach ($address as $key => $addr) {
            $latLon = preg_replace('/,{1}\s*/', '|', $addr->getLatlong());
//            $latLon = preg_replace('/\./', ',', $latLon);
            $coords = explode('|', $latLon);
            $content .= $key . ' >>> ' . ($coords[1] ?? "пусто") . ' >>> ' . ($coords[0] ?? "пусто") . "<br />";
            $address[$key]
                ->setLatitude($coords[1] ?? null)
                ->setLongitude($coords[0] ?? null);
            Proxy::init()->getEntityManager()->persist($address[$key]);
        }

        Proxy::init()->getEntityManager()->flush();

        $data[Render::CONTENT] = $content;
        return (new Render())->render($data, 'simple.html.twig');
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

        /*
$qb = Proxy::init()->getEntityManager()->createQueryBuilder();
$res = $qb->select('cs', 'o')
    ->from(\ClientSettings::class, 'cs')
    ->leftJoin(
        \Orders::class,
        'o',
        Join::WITH,
        $qb->expr()->eq('o.clientId', 'cs.id')
    )
    ->setMaxResults(5)
    ->getQuery()
    ->execute();
foreach ($res as $key => $val) {
    if (isset($val)) {
        $as = get_class($val);
    } else {
        $as = '';
    };
    echo '<br />' . $key . ' >> ' . $as;

}
var_dump(get_class($res[0]));
//        echo "<pre >"; var_dump($res);

die;
//        var_dump($res[0]->getClientId()); die;


return Proxy::init()->getEntityManager()->getRepository(\ClientSettings::class)
    ->matching(
        Criteria::create()
            ->orderBy(['id' => 'ASC'])
            ->setMaxResults(1)

    )->toArray();
*/

//        $res = Proxy::init()->getEntityManager()
//            ->getRepository(\Zorders::class)
//            ->find(3)->getId();
        /** @var \Zorders[] $res */
        $res = Proxy::init()->getEntityManager()
            ->getRepository(\Zorders::class)
            ->matching(
                Criteria::create()
                    ->orderBy(['id' => 'ASC'])
                    ->setMaxResults(1)
//
            )->toArray();
//        var_dump($res); die;
//        $data[Render::CONTENT] = \GuzzleHttp\json_encode($res[0]->getSklad()->getAddr());
        $data[Render::CONTENT] = (string)$res[0]->getStock()->getComments();
//        $data[Render::CONTENT] = $res[0]->getId();
//        $data[Render::CONTENT] = '++';
        return (new Render())->render($data);
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