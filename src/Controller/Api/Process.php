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
            /** @var \Orders $order */
            $order = (new Loader())->loadOrderByOid($ord->id);
            Output::echo($order->getId(), 1);
//            Output::echo((array)$ord->goods);
        }
    }



}