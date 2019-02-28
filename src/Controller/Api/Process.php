<?php

namespace App\Controller\Api;

use App\Helpers\Output;

class Process
{

    /**
     * @param array $orders
     */
    public function processUpdate(array $orders)
    {
        $this->saveUpdateOrders($orders);
        Output::echo('zz', 1);
    }


    private function saveUpdateOrders(array $orders)
    {
        foreach ($orders as $ord) {

            /** @var  $order */
            $order = (new Loader())->loadOrderByOid($ord->id);
            $goods = (new Loader())->loadGoodsByOrder($order);
            $res = (new Checker())->goodsCompare($ord->goods, $goods);

            /** @var bool goodsQtyMatch */
            $goodsQtyMatch = (count($ord->goods) == count($goods));
//            Output::echo($order->getId(). ' >> ' . $order->getOldId() . ' >> ' . count($ord->goods) . ' >> '. count($goods) . '<br />');
//            Output::echo($goods[0]->getDescription(), 1);
//            Output::echo($ord->goods[0], 1);
        }
    }



}