<?php

namespace App\Controller\Api;


use App\Proxy;
use function Sodium\compare;
use Symfony\Component\Console\Output\Output;

class Checker
{

    /**
     * @param \stdClass[] $stdGoods
     * @param \Goods[] $goods
     * @return null
     * @throws \Doctrine\ORM\ORMException
     */
    public function goodsCompare($stdGoods, $goods)
    {
        /** @var bool $goodsQtyMatch */
        $goodsQtyMatch = (count($stdGoods) == count($goods));
        /*
        if($goodsQtyMatch) {
            echo '<br />Кол-во совпало: ' . $goodsQtyMatch . '(' . count($stdGoods) . ') <br />';
        } else {
            echo '<br />Кол-во НЕ совпало: ' . $goodsQtyMatch . '( std: ' . count($stdGoods) . 'goods: '.count($goods). ') <br />';
        }
        */


//        $stdGoodsArray = [];
        /** @var \Goods[] $goodsArray */
        $goodsArray = [];
        foreach ($goods as $key => $val) {
            $goodsArray[$val->getOldId()] = $val;
        }

        foreach ($stdGoods as $key => $val) {
//            $goodsArray[$val->id] = (new Comparator())->setStdGoods($val);
//            $stdGoodsArray[$val->id] = $val;
            $stdGoodsCurrent = $val;
            (new Comparator())->compare($stdGoodsCurrent, $goodsArray[$val->id]);
//            echo '<br />Old Id : ' . $goods[$key]->getOldId() .' >> Is Cancel: ' . $val->is_cancel .' >>> ' . $goods[$key]->getIsCancel();
        }
        Proxy::init()->getEntityManager()->flush();

        return null;
    }



}