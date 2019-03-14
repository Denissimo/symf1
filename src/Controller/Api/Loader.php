<?php

namespace App\Controller\Api;

use App\Helpers\Output;
use App\Proxy;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;
use App\Twig\Render;
use App\Controller\Api\Fields as Api;

class Loader
{

    /**
     * @param \Orders[] $orders
     * @return array|\Porders
     */
    public function loadPorders($orders)
    {
        $orderIds = [];
        foreach ($orders as $ord) {
            if ($ord->getStatus()->getId() == \OrdersTypesModel::SELF_DELIVERY) {
                $orderIds[] = $ord->getOrderId();
            }
        }

        /** @var \Porders $porders */
        $porders = Proxy::init()->getEntityManager()->getRepository(\Porders::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->in(
                            \Porders::ORDER_ID,
                            $orderIds
                        )
                    )
            )->toArray();
        return $porders;
    }

    /**
     * @param \ClientSettings $clientSettings
     * @param \DateTime $from
     * @param \DateTime $to
     * @return \Orders[]
     */
    public function loadApiV3Orders(\ClientSettings $clientSettings, \DateTime $from, \DateTime $to)
    {
        /** @var \Orders[] $orders */
        $orders = Proxy::init()->getEntityManager()->getRepository(\Orders::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\Orders::CLIENT, $clientSettings)
                    )->andWhere(
                        Criteria::expr()->gte(\Orders::GHANGEDATE, $from)
                    )->andWhere(
                        Criteria::expr()->lte(\Orders::GHANGEDATE, $to)
                    )
                    ->setMaxResults(200)
            )->toArray();

        return $orders;
    }


    /**
     * @return \Options
     */
    public function loadLastUpdateTime()
    {
        /** @var \Options $lastUpdateTime */
        $lastUpdateTime = Proxy::init()->getEntityManager()->getRepository(\Options::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\Options::NAME,
                            \Options::ORDERS_UPDATE
                        )
                    )
                    ->setMaxResults(1)
            )->current();
        return $lastUpdateTime;
    }

    /**
     * @return \Options
     */
    public function loadLastOrderId()
    {
        /** @var \Options $lastUpdateId */
        $lastUpdateId = Proxy::init()->getEntityManager()->getRepository(\Options::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\Options::NAME,
                            \Options::ORDERS_LAST_ID
                        )
                    )
                    ->setMaxResults(1)
            )->current();
        return $lastUpdateId;
    }

    /**
     * @param null $clientId
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function loadClientsJoinOrders($clientId = null)
    {
        /*
                $query = 'SELECT c.client_id, o.order_id FROM client_settings c
                              LEFT JOIN orders o ON c.client_id = o.client_id WHERE o.id IS NULL';
        */
        // [id, client_id, qty (orders), orders_qty (orders_count), last_id
        //LEFT JOIN (SELECT oc.client_id, MAX(oc.orders_qty) AS orders_qty FROM orders_count oc GROUP BY oc.client_id) q ON c.client_id = q.client_id

        $where = isset($clientId) ? ' AND client_id = ' . $clientId : null;
        $query = 'SELECT c.id, c.client_id, o.qty, q.orders_qty, q.last_id
  FROM 
  (SELECT * FROM client_settings WHERE active = 1 ' . $where . ' AND client_id NOT IN (2, 238, 1356) ORDER BY client_id) c 
   LEFT JOIN 
  (SELECT o1.client_id, COUNT(o1.id) AS qty  FROM orders o1 GROUP BY o1.client_id) o 
  ON c.id = o.client_id 
   LEFT JOIN (SELECT oc.client_id, oc.orders_qty, oc.last_id FROM orders_count oc) q ON c.client_id = q.client_id
    WHERE o.qty < q.orders_qty OR (o.qty IS NULL AND (q.orders_qty > 0 OR q.orders_qty IS NULL))
 LIMIT ' . Api::LIMIT_CLIENT_ORDERS_LOAD;
//var_dump($query); die;
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
                    WHERE c.active = 1 AND c.client_id BETWEEN ' . $idFrom . ' AND ' . $idTo;

        return implode(
            ',',
            array_column(
                Proxy::init()->getConnection()->query($query)->fetchAll(),
                'client_id'
            )
        );
    }


    /**
     * @param int $oid
     * @return \Orders
     */
    public function loadOrderByOid(int $oid)
    {
        return Proxy::init()->getEntityManager()->getRepository(\Orders::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\Orders::OLDID,
                            $oid
                        )
                    )
                    ->orderBy([\Orders::ID => Criteria::ASC])
                    ->setMaxResults(1)
            )->current();
    }

    /**
     * @param \Orders $order
     * @return \Goods []
     */
    public function loadGoodsByOrder(\Orders $order)
    {
        return Proxy::init()->getEntityManager()->getRepository(\Goods::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\Goods::ORDER_ID,
                            $order->getId()
                        )
                    )
            )->toArray();
    }

    /**
     * заказ по inner_n
     *
     * @param $inner
     * @param \ClientSettings $client
     * @return \Orders
     */
    public function loadOrderInner($inner, \ClientSettings $client)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq(\Orders::CLIENT, $client))
            ->andWhere(Criteria::expr()->eq(\Orders::INNER_N, $inner));

        return Proxy::init()
            ->getEntityManager()
            ->getRepository(\Orders::class)
            ->matching($criteria)
            ->first();
    }

    /**
     * заказ по order_id
     *
     * @param $orderId
     * @param \ClientSettings $client
     * @return \Orders
     */
    public function loadOrderId($orderId, \ClientSettings $client)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq(\Orders::CLIENT, $client))
            ->andWhere(Criteria::expr()->eq(\Orders::ORDER_ID, $orderId));

        return Proxy::init()
            ->getEntityManager()
            ->getRepository(\Orders::class)
            ->matching($criteria)
            ->first();
    }

    /**
     * @param $orderId
     * @return \Porders
     */
    public function loadPOrderId($orderId)
    {
        return Proxy::init()
            ->getEntityManager()
            ->getRepository(\Porders::class)
            ->matching(Criteria::create()->where(\Porders::ORDER_ID, $orderId))
            ->first();
    }

    /**
     * @param $id
     * @return \Marks|object|null
     */
    public function loadMarksId($id)
    {
        return Proxy::init()
            ->getEntityManager()
            ->getRepository(\Marks::class)
            ->find($id);
    }

}