<?php

namespace App\Api;

use App\Api\Response\Builder;
use App\Helpers\Output;
use App\Proxy;
use App\Api\Fields as Api;

class Process
{

    /**
     * @param array $orders
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function processUpdate(array $orders)
    {
        return $this->saveUpdateOrders($orders);
    }


    /**
     * @param array $orders
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    private function saveUpdateOrders(array $orders)
    {
        $lostUpdateTime = new \DateTime();
        $lostId = end($orders)->id;
        $firstUpdateTime = \DateTime::createFromFormat('Y-m-d H:i:s', reset($orders)->change_date);
            Proxy::init()->getLogger()->addWarning('Orders qty: ' . count($orders));
            Proxy::init()->getLogger()->addWarning('Firest id: ' . \GuzzleHttp\json_encode(reset($orders)->id));
            Proxy::init()->getLogger()->addWarning('firstUpdateTime: ' . \GuzzleHttp\json_encode($firstUpdateTime));
        foreach ($orders as $ord) {
            $order = (new Loader())->loadOrderByOid($ord->id);

            if (is_object($order)) {

                $goods = (new Loader())->loadGoodsByOrder($order);
                isset($ord->goods) ? (new Checker())->goodsCompare($ord->goods, $goods) : null;
                $address = (new Builder())->buildAddress($order->getAddress(), $ord);
                $orderBill = (new Builder())->buildOrderBill($order->getOrderBill(), $ord);
                $orderSettings = (new Builder())->buildOrderSettings($order->getOrderSettings(), $ord);
                $currentOrder = (new Builder())->buildOrder($order, $ord);

                $currentOrder
                    ->setAddress($address)
                    ->setOrderBill($orderBill)
                    ->setOrderSettings($orderSettings);
                Proxy::init()->getEntityManager()->persist($currentOrder);
            } else {
                $newDt = \DateTime::createFromFormat('Y-m-d H:i:s', $ord->change_date);
                $lostUpdateTime = $newDt < $lostUpdateTime ? $newDt : $lostUpdateTime;
                $lostId = (int)$ord->id;
            }

        }
            Proxy::init()->getEntityManager()->flush();
        $endUpdateTime = \DateTime::createFromFormat('Y-m-d H:i:s', end($orders)->change_date);
            Proxy::init()->getLogger()->addWarning('Last ID: ' . \GuzzleHttp\json_encode(end($orders)->id));
            Proxy::init()->getLogger()->addWarning('endUpdateTime: ' . \GuzzleHttp\json_encode($endUpdateTime));
        $endOrderId = (int)end($orders)->id;
        $finalUpdateTime = $endUpdateTime < $lostUpdateTime ? $endUpdateTime : $lostUpdateTime;
            Proxy::init()->getLogger()->addWarning('lostId: ' . $lostId);
            Proxy::init()->getLogger()->addWarning('lostUpdateTime: ' . \GuzzleHttp\json_encode($lostUpdateTime));
            Proxy::init()->getLogger()->addWarning('finalUpdateTime: ' . \GuzzleHttp\json_encode($endUpdateTime));
        $finalOrderId = $endOrderId < $lostId ? $endOrderId : $lostId;
        $useLastId = (int)($firstUpdateTime == $endUpdateTime && count($orders) > 1);
        return [
            \Options::ORDERS_UPDATE => $finalUpdateTime,
            \Options::ORDERS_LAST_ID => $finalOrderId,
            \Options::ORDERS_USE_ID => $useLastId
        ];
    }

}