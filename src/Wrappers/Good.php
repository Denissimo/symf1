<?php

namespace App\Wrappers;

/**
 * Class Good
 * @package App\Wrappers
 */
class Good
{
    /** @var string|null */
    public $artname;

    /** @var float|null */
    public $weight;

    /** @var float|null */
    public $count_weight;

    /** @var int|null */
    public $count;

    /** @var string|null */
    public $price;

    /** @var int|null */
    public $is_cancel;

    /** @var string|null */
    public $v_akt_id;

    /** @var string|null */
    public $gstatus;

    /** @var string */
    public $nds;

    /** @var int */
    public $order_id;

    /** @var string|null */
    public $articul;

    /**
     * @var
     * @duplicated
     */
    public $voc_id;

    /**
     * @var
     * @duplicated
     */
    public $zorder_id;

    /**
     * @var
     * @duplicated
     */
    public $on_ware;

    /**
     * @var
     * @duplicated
     */
    public $sa_vact_id;

    public function __construct(\Goods $good)
    {
        $this->artname = $good->getArticle();
        $this->weight = $good->getWeight();
        $this->count_weight = $good->getCountWeight();
        $this->count = $good->getCount();
        $this->price = $good->getPrice();
        $this->is_cancel = $good->getIsCancel();
        $this->v_akt_id = $good->getVAktId();
        $this->gstatus = $good->getGoodsStatus()->getGoodsStatus();
        $this->nds = $good->getGoodsNdsType()->getNds();
        $this->order_id = $good->getOrderId();
        $this->articul = $good->getDescription();
    }
}