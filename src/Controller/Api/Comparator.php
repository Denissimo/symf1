<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 07.03.2019
 * Time: 19:07
 */

namespace App\Controller\Api;


use App\Controller\Api\Response\Builder;
use App\Helpers\Output;
use App\Proxy;

class Comparator
{
    /** @var \Goods | null */
    private $goods;

    /** @var \stdClass */
    private $stdGoods;

    /**
     * @param \stdClass $stdGoods
     * @param \Goods | null $goods
     * @return null
     * @throws \Doctrine\ORM\ORMException
     */
    public function compare($stdGoods,$goods)
    {
//        $this->stdGoods = $stdGoods;
//        $this->goods = $goods;
//        Output::echo($goods->getOldId());
        if($goods) {
            $isCountChanged = $this->checkCount($stdGoods, $goods);
            $isParamsChanged = $this->checkParasms($stdGoods, $goods);
            if($isCountChanged || $isParamsChanged){
                $currentGoods = (new Builder())->buildGoods($goods, $stdGoods);
            } else {
                $currentGoods = $goods;
            }
        } else {
            $currentGoods = (new Builder())->buildGoods(new \Goods(), $stdGoods);
        }
        Proxy::init()->getEntityManager()->persist($currentGoods);
        return null;
    }


    /**
     * @return \Goods
     */
    public function getGoods(): \Goods
    {
        return $this->goods;
    }

    /**
     * @param \Goods $goods
     * @return Comparator
     */
    public function setGoods(\Goods $goods): Comparator
    {
        $this->goods = $goods;
        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getStdGoods(): \stdClass
    {
        return $this->stdGoods;
    }

    /**
     * @param \stdClass $stdGoods
     * @return Comparator
     */
    public function setStdGoods(\stdClass $stdGoods): Comparator
    {
        $this->stdGoods = $stdGoods;
        return $this;
    }

    /**
     * @param \stdClass $stdGoods
     * @param \Goods | null $goods
     * @return bool
     */
    private function checkParasms($stdGoods, $goods)
    {
        $ndsType = ($goods->getGoodsNdsType()) ? $goods->getGoodsNdsType()->getNds() : null;
//        Output::echo('OldId: ' .$goods->getOldId(). ' >> Nds: '.$ndsType);
        return
            (bool)$stdGoods->is_cancel ||
            ($stdGoods->v_akt_id != $goods->getVAktId()) ||
            ($stdGoods->price != $goods->getPrice()) ||
            ($stdGoods->nds != $ndsType);
    }

    /**
     * @param \stdClass $stdGoods
     * @param \Goods | null $goods
     * @return bool
     */
    private function checkCount($stdGoods, $goods)
    {
        return $stdGoods->count != $goods->getCount();
    }

}