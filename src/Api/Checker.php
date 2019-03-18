<?php

namespace App\Api;


use App\Proxy;
use function Sodium\compare;
use Symfony\Component\Console\Output\Output;
use App\Api\Response\Builder;

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
        /** @var \Goods[] $goodsArray */
        $goodsArray = [];
        foreach ($goods as $key => $val) {
            $goodsArray[$val->getOldId()] = $val;
        }

        foreach ($stdGoods as $key => $val) {
            $stdGoodsCurrent = $val;
            if (isset($goodsArray[$val->id])) {
                $currentGoods = (new Comparator)->compare($stdGoodsCurrent, $goodsArray[$val->id]);
                unset($goodsArray[$val->id]);
            } else {
                $currentGoods = (new Builder())->buildGoods(new \Goods(), $stdGoodsCurrent);
            }
            Proxy::init()->getEntityManager()->persist($currentGoods);
        }

        // Остальные элементы goods удаляем
        foreach ($goodsArray as $key => $val) {
            Proxy::init()->getEntityManager()->remove($val);
        }

        Proxy::init()->getEntityManager()->flush();

        return null;
    }


}