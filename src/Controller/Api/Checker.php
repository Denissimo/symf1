<?php

namespace App\Controller\Api;


class Checker
{
    /**
     * @param \stdClass[] $stdGoods
     * @param \Goods[] $goods
     * @return null
     */
    public function goodsCompare($stdGoods, $goods)
    {
        /** @var bool $goodsQtyMatch */
        $goodsQtyMatch = (count($stdGoods) == count($goods));
        echo 'Кол-во совпало: ' . $goodsQtyMatch . '('. count($stdGoods) .') <br />';
        foreach ($stdGoods as $key => $val) {
            echo '<br />Is Cancel: ' . $val->is_cancel .' >>> ' . $goods[$key]->getIsCancel();
        }
        return null;
    }
}