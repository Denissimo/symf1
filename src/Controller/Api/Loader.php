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
        /*
                $query = 'SELECT c.client_id, o.order_id FROM client_settings c
                              LEFT JOIN orders o ON c.client_id = o.client_id WHERE o.id IS NULL';
        */
        // [id, client_id, qty (orders), orders_qty (orders_count)
        $query = 'SELECT c.id, c.client_id, o.qty, q.orders_qty
  FROM 
  (SELECT *FROM client_settings WHERE active = 1) c 
   LEFT JOIN 
  (SELECT o1.client_id, COUNT(o1.id) AS qty  FROM orders o1 GROUP BY o1.client_id) o 
  ON c.id = o.client_id 
   LEFT JOIN (SELECT oc.client_id, MAX(oc.orders_qty) AS orders_qty FROM orders_count oc GROUP BY oc.client_id) q ON c.client_id = q.client_id
 WHERE o.qty < q.orders_qty OR (o.qty IS NULL AND q.orders_qty > 0)';

        return (array)Proxy::init()->getConnection()->query($query)->fetchAll();
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