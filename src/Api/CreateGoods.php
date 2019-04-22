<?php


namespace App\Api;


class CreateGoods
{
    public $articul;
    public $artname;
    public $count;
    public $weight;
    public $price;
    public $nds;

    /**
     * CreateGoods constructor.
     */
    public function __construct(array $goods)
    {
        $this->articul = $goods['articul'];
        $this->artname = $goods['artname'];
        $this->count = $goods['count'];
        $this->weight = $goods['weight'];
        $this->price = $goods['price'];
        $this->nds = $goods['nds'];
    }

}