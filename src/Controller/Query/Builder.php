<?php

namespace App\Controller\Query;

use App\Proxy;
use Doctrine\ORM\Query\Expr\Join;


class Builder
{


    public function queryApps()
    {
        $qb = Proxy::init()->getEntityManager()->createQueryBuilder();
        return $qb
            ->select('a, c')
            ->from(\Apps::class, 'a')
            ->leftJoin(
                \Comments::class,
                'c',
                Join::ON,
                $qb->expr()->eq('c.appId', 'a.id')
            )
            ->where('a.userId=9')
//            ->where($qb->expr()->eq('a.id', 9))
            ->setMaxResults(50)->getQuery()
            ->useQueryCache(false)
            ->useResultCache(false)
            ->execute()
            ;
    }

    public function queryComments(array $appsIds)
    {
        $qb = Proxy::init()->getEntityManager()->createQueryBuilder();
        return $qb
            ->select('c')
            ->from(\Comments::class, 'c')
//            ->where('a.userId=9')
            ->where($qb->expr()->in('c.appId', $appsIds))
            ->setMaxResults(50)->getQuery()
            ->useQueryCache(false)
            ->useResultCache(false)
            ->execute()
            ;
    }
}