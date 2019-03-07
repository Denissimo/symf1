<?php

namespace App\Controller\Api;

use App\Helpers\Output;

class Process
{

    /**
     * @param array $orders
     * @throws \Exception
     */
    public function processUpdate(array $orders)
    {
//        $this->saveUpdateOrders($orders);
        $res = $this->saveUpdateOrders($orders);
    }


    /**
     * @param array $orders
     * @return null
     * @throws \Exception
     */
    private function saveUpdateOrders(array $orders)
    {
        $lostUpdateTime = new \DateTime();
        foreach ($orders as $ord) {

            //Output::echo($ord->id);
            //isset($ord->change_date) ? \DateTime::createFromFormat('Y-m-d H:i:s', $ord->change_date) : null)
            /** @var  $order */
            $order = (new Loader())->loadOrderByOid($ord->id);
//            $res[] = gettype($order);
            if(is_object($order)) {
                $goods = (new Loader())->loadGoodsByOrder($order);
                $res = (new Checker())->goodsCompare($ord->goods, $goods);

                /** @var bool goodsQtyMatch */
                $goodsQtyMatch = (count($ord->goods) == count($goods));
            Output::echo($order->getId(). ' >> ' . $order->getOldId() . ' >> ' . count($ord->goods) . ' >> '. count($goods) . '<br />');

            } else {
                $newDt = \DateTime::createFromFormat('Y-m-d H:i:s', $ord->change_date);
                $lostUpdateTime = $newDt < $lostUpdateTime ? $newDt : $lostUpdateTime;
            }
        }
        $endUpdateTime = \DateTime::createFromFormat('Y-m-d H:i:s', end($orders)->change_date);
        $finalUpdateTime = $endUpdateTime <  $lostUpdateTime ? $endUpdateTime : $lostUpdateTime;
        Output::echo($finalUpdateTime);
        return $res;
    }



}