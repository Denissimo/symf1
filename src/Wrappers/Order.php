<?php

namespace App\Wrappers;

use App\Controller\Api\Loader;

/**
 * обертка для \Orders подготавливает объект для возврата его по апи
 *
 * Class Order
 * @package App\Wrappers
 */
class Order
{
    /** @var \Orders */
    protected $order;
    /** @var Loader */
    protected $loader;

    /** @var string - id заказа */
    public $order_id;

    /** @var string|null */
    public $inner_id;

    /** @var string|null - штрихкод */
    public $shk;

    /** @var string - дата доставки */
    public $delivery_date;

    /** @var int - статус */
    public $status;

    /** @var float - вес */
    public $order_weight;

    /** @var string|null - цена доставки */
    public $price_delivery;

    /** @var string|null - цена клиенту */
    public $price_client;

    /** @var string - дата изменения */
    public $change;

    /** @var string|null */
    public $reciepient;

    /** @var array */
    public $order_goods = [];

    /** @var string */
    public $podstatus;

    /** @var string */
    public $cancel_reason;

    /** @var string */
    public $update_date_flag;

    /** @var string */
    public $update_date_reason;

    /** @var string|null */
    public $bill_id;

    /** @var int - тип оплаты (фактически boolean - карта-1/нал-0) */
    public $paymentType;

    /**
     * Order constructor.
     * @param \Orders $order
     */
    public function __construct(\Orders $order)
    {
        $this->order = $order;
        $this->loader = new Loader();

        $this->order_id = $order->getOrderId();
        $this->inner_id = $order->getInnerN();
        $this->shk = $order->getShk();
        $this->order_weight = $order->getOrderWeight();
        $this->bill_id = $order->getBillId();

        $this->paymentType = !$order->getCard() ? 2 : 1;

        $this->status = $order->getStatus()->getId();

        $this->delivery_date = $order->getDeliveryDate()->format('Y-m-d');
        $this->change = $order->getChangeDate()->format('Y-m-d H:i:s');

        $this->reciepient = $order->getOrderSettings()->getReciepientName();

        $this->price_delivery = $order->getOrderBill()->getPriceDelivery();
        $this->price_client = $order->getOrderBill()->getPriceClient();

        $this->findPodStatus();
        $this->findGoods();
        $this->findCancelReason();
    }

    /**
     * находим подстатус
     */
    protected function findPodStatus()
    {
        if ($this->order->getType()->getType() !== \OrdersTypesModel::SELF_DELIVERY) {
            return;
        }
        // если самовывоз
        $pOrder = $this->loader->loadPOrderId($this->order->getOrderId());
        if ($pOrder) {
            $this->podstatus = $pOrder->getPodstatus()->getPodstatus();
        }
    }

    /**
     * подгрузка GOODS
     */
    protected function findGoods()
    {
        if ($this->order->getStatus()->getId() !== \OrdersStatusModel::STATUS_PARTIAL_FAILURE) {
            return;
        }
        // Частичный отказ
        $this->order_goods = array_map(function (\Goods $good) {
            return new Good($good);
        }, $this->order->getGoods()->toArray());
    }

    /**
     * поднимаем update_date_flag and update_date_reason
     */
    public function findUpdateDateReason()
    {
        $this->update_date_flag = $this->order->getUpdateDateFlag();
        if ($this->update_date_flag && $this->order->getPReason()) {
            $this->update_date_reason = $this->loader->loadMarksId($this->order->getPReason())->getMarkDescr();
        }
    }

    /**
     * поднимаем cancel_reason
     */
    protected function findCancelReason()
    {
        if ($this->order->getStatus()->getId() !== \OrdersStatusModel::STATUS_CANCEL ||
            !$this->order->getCReason()) {
            return;
        }
        // пишем статус отмены только если была отмена заказа
        $this->cancel_reason = $this->loader->loadMarksId($this->order->getCReason())->getMarkDescr();
    }
}