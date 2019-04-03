<?php

namespace App\Api;

use App\Helpers\Output;
use App\Proxy;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;
use App\Twig\Render;
use App\Api\Fields as Api;

class Loader
{

    /**
     * @param string $entityName
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    protected function getRepository($entityName)
    {
        return Proxy::init()->getEntityManager()->getRepository($entityName);
    }

    /**
     * @param \Orders[] $orders
     * @return array|\Porders
     */
    public function loadPorders($orders)
    {
        $orderIds = [];
        foreach ($orders as $ord) {
            if ($ord->getStatus()->getId() == \OrdersTypesModel::PICKUP) {
                $orderIds[] = $ord->getOrderId();
            }
        }

        /** @var \Porders $porders */
        $porders = $this->getRepository(\Porders::class)
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
        $orders = $this->getRepository(\Orders::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\Orders::CLIENT, $clientSettings)
                    )->andWhere(
                        Criteria::expr()->gte(\Orders::GHANGEDATE, $from)
                    )->andWhere(
                        Criteria::expr()->lte(\Orders::GHANGEDATE, $to)
                    )
                    ->setMaxResults(Api::MAX_LOAD_ORDERS)
            )->toArray();

        return $orders;
    }

    /**
     * @param string $name
     * @return \Options
     */
    public function loadOption(string $name)
    {
        return $this->getRepository(\Options::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\Options::NAME,
                            $name
                        )
                    )
                    ->setMaxResults(1)
            )->current();
    }

    /**
     * @return int
     */
    public function loadBiggestOldId()
    {
        /** @var \Orders $lastOrder */
        $lastOrder = $this->getRepository(\Orders::class)
            ->matching(
                Criteria::create()
                    ->orderBy([\Orders::ID => Criteria::DESC])
                    ->setMaxResults(1)
            )->current();
        return $lastOrder->getOldId();
    }

    /**
     * @return \DateTime|null
     */
    public function loadLastStockUpdated()
    {
        /** @var \ZordersStocksModels $lastStock */
        $lastStock = $this->getRepository(\ZordersStocksModels::class)
            ->matching(
                Criteria::create()
                    ->orderBy([\ZordersStocksModels::UPDATED => Criteria::DESC])
                    ->setMaxResults(1)
            )->current();
        return $lastStock->getUpdated();
    }

    /**
     * @param null $clientId
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function loadClientsJoinOrders($clientId = null)
    {
        $where = isset($clientId) ? ' AND client_id = ' . $clientId : null;
        $query = 'SELECT c.id, c.client_id, o.qty, q.orders_qty, q.last_id
  FROM 
  (SELECT * FROM client_settings WHERE active = 1 ' . $where . ' AND client_id NOT IN (1356) ORDER BY client_id) c 
   LEFT JOIN 
  (SELECT o1.client_id, COUNT(o1.id) AS qty  FROM orders o1 GROUP BY o1.client_id) o 
  ON c.id = o.client_id 
   LEFT JOIN (SELECT oc.client_id, oc.orders_qty, oc.last_id FROM orders_count oc) q ON c.client_id = q.client_id
    WHERE o.qty < q.orders_qty OR (o.qty IS NULL AND (q.orders_qty > 0 OR q.orders_qty IS NULL))
 LIMIT ' . Api::LIMIT_CLIENT_ORDERS_LOAD;

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
        return $this->getRepository(\Orders::class)
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
        return $this->getRepository(\Goods::class)
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
     * @param $orderId
     * @return \Porders
     */
    public function loadPOrderId($orderId)
    {
        return $this->getRepository(\Porders::class)
            ->matching(Criteria::create()->where(
                Criteria::expr()->eq(\Porders::ORDER_ID, $orderId))
            )
            ->first();
    }

    /**
     * @return array|\Marks[]
     */
    public function loadMarks()
    {
        return $this->getRepository(\Marks::class)->findAll();
    }

    /**
     * @param $id
     * @return \Marks|object|null
     */
    public function loadMarksId($id)
    {
        return $this->getRepository(\Marks::class)
            ->find($id);
    }

}