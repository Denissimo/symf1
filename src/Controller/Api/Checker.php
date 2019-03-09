<?php

namespace App\Controller\Api;


use function Sodium\compare;
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

        /** @var Comparator[] $goodsArray */
        $stdGoodsArray = [];
        $goodsArray = [];
        $comparators = [];
        foreach ($goods as $key => $val) {
//            $goodsArray[$val->getOldId()] = (new Comparator())->setGoods($val);
            $goodsArray[$val->getOldId()] = $val;
        }

        foreach ($stdGoods as $key => $val) {
//            $goodsArray[$val->id] = (new Comparator())->setStdGoods($val);
            $stdGoodsArray[$val->id] = $val;
            $stdGoodsCurrent = $val;
            $comparators[] = (new Comparator())->compare($stdGoodsCurrent, $goodsArray[$val->id]);
            echo '<br />Old Id : ' . $goods[$key]->getOldId() .' >> Is Cancel: ' . $val->is_cancel .' >>> ' . $goods[$key]->getIsCancel();
        }


/*
        foreach ($goodsArray as  $key => $val){
            $isParamsChamged = $this->checkParasms($val->getStdGoods(), $val->getGoods());
            $isCountChamged = $this->checkCount($val->getStdGoods(), $val->getGoods());
        }
*/
/*
        foreach ($goods as $g) {
            $artname = $g->getOldId();
            $gStd = $goodsArrayOfStd[$g->getOldId()]['goods'];
            $isCountChanged = $this->checkCount($gStd, $g);
        }
*/

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