<?php

namespace App\Controller\Api;

use App\Proxy;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;
use App\Twig\Render;

class Loader
{

    /**
     * @return []
     * @throws \Doctrine\DBAL\DBALException
     */
    public function loadClientsJoinOrders()
    {
        $query = 'SELECT c.client_id, o.order_id FROM client_settings c 
                      LEFT JOIN orders o ON c.client_id = o.client_id WHERE o.id IS NULL';
        return array_column(
            Proxy::init()->getConnection()->query($query)->fetchAll(),
            'client_id'
        );
    }

    /**
     * @param int $idFrom
     * @param int $idTo
     * @return string
     * @throws \Doctrine\DBAL\DBALException
     */
    public function loadClientsListIds(int $idFrom, int $idTo)
    {
        $query = 'SELECT c.client_id FROM client_settings c 
                    WHERE c.client_id BETWEEN ' . $idFrom . ' AND ' . $idTo;
        return implode(
            ',',
            array_column(
                Proxy::init()->getConnection()->query($query)->fetchAll(),
                'client_id'
            )
        );
    }

}