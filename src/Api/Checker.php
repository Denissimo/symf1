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
     * @param \Orders $order
     * @return null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function goodsCompare($stdGoods, $goods, $order)
    {
        /** @var \Goods[] $goodsArray */
        $goodsArray = [];
        foreach ($goods as $key => $val) {
            $goodsArray[$val->getOldId()] = $val;
        }

        foreach ($stdGoods as $key => $val) {
            $stdGoodsCurrent = $val;
            if (isset($goodsArray[$val->id])) {
                $currentGoods =(new Comparator($stdGoodsCurrent, $goodsArray[$val->id]))->getGoods();
                unset($goodsArray[$val->id]);
            } else {

                $currentGoods = (new Builder())->buildGoods(new \Goods(), $stdGoodsCurrent);
                $currentGoods->setOrder($order);
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