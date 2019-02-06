<?php

namespace App\Controller\Api\Response;

use App\Controller\Api\Structure;

class Builder extends Structure
{
    public function buildOrders(array $orders)
    {
        foreach ($orders as $ord) {
            $newOrder = (new \Orders());

        }
    }
}