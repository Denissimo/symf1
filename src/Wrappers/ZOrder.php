<?php

namespace App\Wrappers;

/**
 * обертка к \Zorders
 *
 * Class ZOrder
 * @package App\Wrappers
 */
class ZOrder
{
    public $zorder_id;

    /** @var string|null */
    public $inner_id;

    /** @var string */
    public $date;

    /** @var int */
    public $status;

    /** @var string|null */
    public $weight;

    /** @var string|null */
    public $price;

    /**
     * @var
     * @duplicated
     */
    public $cr_name;

    /**
     * @var
     * @duplicated
     */
    public $cr_phone;


    public function __construct(\Zorders $zOrder)
    {
        $this->zorder_id = $zOrder->getId();
        $this->inner_id = $zOrder->getInner();
        $this->date = $zOrder->getDate()->format('Y-m-d H:i:s');
        $this->status = $zOrder->getStatus()->getId();
        $this->weight = $zOrder->getWeight();
        $this->price = $zOrder->getZprice();
    }
}