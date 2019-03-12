<?php

namespace App\Controller\Api;

use App\Controller\Api\Response\Builder;
use App\Helpers\Output;
use App\Proxy;

class Process
{

    /**
     * @param array $orders
     * @return bool|\DateTime
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function processUpdate(array $orders)
    {
        return $this->saveUpdateOrders($orders);
    }


    /**
     * @param array $orders
     * @return bool|\DateTime
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    private function saveUpdateOrders(array $orders)
    {
        $lostUpdateTime = new \DateTime();
        foreach ($orders as $ord) {

            $order = (new Loader())->loadOrderByOid($ord->id);
            if(is_object($order)) {
                $goods = (new Loader())->loadGoodsByOrder($order);
                isset($ord->goods) ? (new Checker())->goodsCompare($ord->goods, $goods) : null;

            } else {
                $newDt = \DateTime::createFromFormat('Y-m-d H:i:s', $ord->change_date);
                $lostUpdateTime = $newDt < $lostUpdateTime ? $newDt : $lostUpdateTime;
            }

            $address = (new Builder())->buildAddress(new \Address(), $ord);
            $orderBill = (new Builder())->buildOrderBill(new \OrdersBills(), $ord);
            $orderSettings = (new Builder())->buildOrderSettings(new \OrdersSettings(), $ord);
            $currentOrder = (new Builder())->buildOrder($order, $ord);

            $currentOrder
                ->setAddress($address)
                ->setOrderBill($orderBill)
                ->setOrderSettings($orderSettings);

            Proxy::init()->getEntityManager()->persist($currentOrder);
        }
        Proxy::init()->getEntityManager()->flush();
        $endUpdateTime = \DateTime::createFromFormat('Y-m-d H:i:s', end($orders)->change_date);
        $finalUpdateTime = $endUpdateTime <  $lostUpdateTime ? $endUpdateTime : $lostUpdateTime;
        return $finalUpdateTime;
    }



}