<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 07.03.2019
 * Time: 19:07
 */

namespace App\Controller\Api;


class Comparator
{
    /** @var \Goods | null */
    private $goods;

    /** @var \stdClass */
    private $stdGoods;

    /**
     * @param \stdClass $stdGoods
     * @param \Goods $goods
     * @return null
     */
    public function compare(\stdClass $stdGoods, \Goods $goods)
    {
        $this->stdGoods = $stdGoods;
        $this->goods = $goods;
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


}