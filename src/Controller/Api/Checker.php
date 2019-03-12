<?php

namespace App\Controller\Api;


use App\Proxy;
use Symfony\Component\Console\Output\Output;
use App\Controller\Api\Response\Builder;

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

        /** @var \Goods[] $goodsArray */
        $goodsArray = [];
        foreach ($goods as $key => $val) {
            $goodsArray[$val->getOldId()] = $val;
        }

        foreach ($stdGoods as $key => $val) {
            $stdGoodsCurrent = $val;
            if(isset($goodsArray[$val->id])) {
                $currentGoods = (new Comparator())->compare($stdGoodsCurrent, $goodsArray[$val->id]);
                unset($goodsArray[$val->id]);
            } else {
                $currentGoods = (new Builder())->buildGoods(new \Goods(), $stdGoodsCurrent);
            }
            Proxy::init()->getEntityManager()->persist($currentGoods);
        }

        // Остальные элементы goods удаляем
        foreach ($goodsArray as $key=>$val)
        {
            Proxy::init()->getEntityManager()->remove($val);
        }

        Proxy::init()->getEntityManager()->flush();

        return null;
    }



}