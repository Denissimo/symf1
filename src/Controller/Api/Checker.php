<?php

namespace App\Controller\Api;


use Symfony\Component\Console\Output\Output;

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
        echo '<br />Кол-во совпало: ' . $goodsQtyMatch . '('. count($stdGoods) .') <br />';

        $goodsArrayOfStd = [];
        foreach ($stdGoods as $key => $val) {
            $goodsArrayOfStd[$val->id]['goods'] = $val;
            echo '<br />Old Id : ' . $goods[$key]->getOldId() .' >> Is Cancel: ' . $val->is_cancel .' >>> ' . $goods[$key]->getIsCancel();
        }

        foreach ($goods as $g) {
            $artname = $g->getOldId();
            $gStd = $goodsArrayOfStd[$artname]['goods'];
            $isCountChanged = $this->checkCount($gStd, $g);
        }

        return null;
    }

    /**
     * @param \stdClass $stdGoods
     * @param \Goods $goods
     * @return bool
     */
    private function checkParasms($stdGoods, $goods)
    {
        return
            (bool)$stdGoods->is_cancel ||
            ($stdGoods->v_akt_id == $goods->getVAktId()) ||
            ($stdGoods->nds == $goods->getGoodsNdsType()->getNds());
    }

    /**
     * @param \stdClass $stdGoods
     * @param \Goods $goods
     * @return bool
     */
    private function checkCount($stdGoods, $goods)
    {
        return $stdGoods->count == $goods->getCount();
    }

}