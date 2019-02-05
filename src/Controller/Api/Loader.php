<?php

namespace App\Controller\Api;

use App\Proxy;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;

class Loader
{

    public function loadClients()
    {
        $qb = Proxy::init()->getConnecton();
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
            if(isset($val)){
                $as = get_class($val);
            } else {
                $as = '';
            };
            echo '<br />'. $key . ' >> ' . $as;

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
    }

}