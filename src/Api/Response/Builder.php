<?php

namespace App\Api\Response;

use App\Api\Structure as Fields;
use App\Proxy;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;
use App\Helpers\Output;

class Builder
{
    const
        TYPE = 'object',
        DEFAULT_ID = 1;

    const
        ORDER_ORDER_ID = 'order_id',
        ORDER_INNER_ID = 'inner_id',
        ORDER_SHK = 'shk',
        ORDER_DELIVERY_DATE = 'delivery_date',
        ORDER_STATUS = 'status',
        ORDER_ORDER_WEIGHT = 'order_weight',
        ORDER_PRICE_DELIVERY = 'price_delivery',
        ORDER_PRICE_CLIENT = 'price_client',
        ORDER_CHANGE = 'change',
        ORDER_RECEPIENT = 'reciepient',
        ORDER_ORDER_GOODS = 'order_goods',
        ORDER_PODSTATUS = 'podstatus',
        ORDER_CANCEL_REASON = 'cancel_reason',
        ORDER_UPDATE_DATE_FLAG = 'update_date_flag',
        ORDER_UPDATE_DATE_REASON = 'update_date_reason',
        ORDER_BILL_ID = 'bill_id',
        ORDER_PAYMENT_TYPE = 'paymentType',
        GOODS_ID = "id",
        GOODS_ARTNAME = "artname",
        GOODS_WEIGHT = "weight",
        GOODS_COUNT_WEIGHT = "count_weight",
        GOODS_COUNT = "count",
        GOODS_VOC_ID = "voc_id",
        GOODS_ARTICUL = "articul",
        GOODS_PRICE = "price",
        GOODS_IS_CANCEL = "is_cancel",
        GOODS_ORDER_ID = "order_id",
        GOODS_ZORDER_ID = "zorder_id",
        ZORDER_ID = "zorder_id",
        GOODS_ON_WARE = "on_ware",
        GOODS_GSTATUS = "gstatus",
        GOODS_V_AKT_ID = "v_akt_id",
        GOODS_SA_VACT_ID = "sa_vact_id",
        GOODS_NDS = "nds";

    /**
     * @param array $results
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function process(array $results)
    {
        foreach ($results as $orders) {
            $this->saveOrders((array)$orders);
        }
    }


    /**
     * @param array $orders
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function saveOrders(array $orders)
    {
        $duplicates = (array)$this->checkDuplicateOrders($orders);
        foreach ($orders as $ord) {
            if (isset($ord->id) && !in_array($ord->id, $duplicates)) {
                $address = $this->buildAddress(new \Address(), $ord);
                $orderBill = $this->buildOrderBill(new \OrdersBills(), $ord);
                $orderSettings = $this->buildOrderSettings(new \OrdersSettings(), $ord);
                $order = $this->buildOrder(new \Orders(), $ord);

                $order
                    ->setAddress($address)
                    ->setOrderBill($orderBill)
                    ->setOrderSettings($orderSettings);

                Proxy::init()->getEntityManager()->persist($order);
                isset($ord->goods) ? $this->saveGoods((array)$ord->goods, $order) : null;
            }
        }
        Proxy::init()->getEntityManager()->flush();
    }


    /**
     * @param array $orders
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    private function checkDuplicateOrders(array $orders)
    {
        foreach ($orders as $key => $res) {
            if (!is_object($res) || !isset($res->id)) continue;
            $idList[$key] = $res->id;
        }
//        die;
        $idRow = isset($idList) ? implode(', ', $idList) : '0';
        $query = 'SELECT old_id FROM orders WHERE old_id IN(' . $idRow . ')';
        return array_column(Proxy::init()->getConnection()->query($query)->fetchAll(), 'old_id');
    }


    /**
     * @param array $goods
     * @param \Orders $order
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private
    function saveGoods(array $goods, \Orders $order)
    {
        foreach ($goods as $good) {
            if (gettype($good) == self::TYPE) {
                $goodsNew = $this->buildGoods(new \Goods(), $good)->setOrder($order);
                Proxy::init()->getEntityManager()->persist($goodsNew);
            }
        }
    }


    /**
     * @param \Goods $goods
     * @param \stdClass $good
     * @return \Goods
     */
    public function buildGoods(\Goods $goods, \stdClass $good)
    {
        /** @var \GoodsStatusModel $client */
        $goodStatus = Proxy::init()->getEntityManager()->getRepository(\GoodsStatusModel::class)
            ->find($good->gstatus);

        /** @var \NdsType | null $client */
        $ndsType = $good->nds ? Proxy::init()->getEntityManager()->getRepository(\NdsType::class)
            ->find($good->nds) : null;

        return $goods
            ->setOldId($good->id)
            ->setGoodsStatus($goodStatus)
            ->setGoodsNdsType($ndsType)
            ->setArticle($good->articul)
            ->setCount($good->count)
            ->setCountWeight($good->count_weight)
            ->setDescription($good->artname)
            ->setIsCancel($good->is_cancel)
            ->setPrice($good->price)
            ->setVAktId($good->v_akt_id)
            ->setWeight($good->weight);

    }

    /**
     * @param \Orders $order
     * @param \stdClass $ord
     * @return \Orders
     */
    public function buildOrder(\Orders $order, \stdClass $ord)
    {
        /** @var \ClientSettings $client */
        $client = Proxy::init()->getEntityManager()->getRepository(\ClientSettings::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\ClientSettings::CLIENT_ID, $ord->client_id)
                    )
                    ->setMaxResults(1)

            )->current();

        /** @var \OrdersStatusModel $status */
        $status = isset($ord->status) ? Proxy::init()->getEntityManager()->getRepository(\OrdersStatusModel::class)
            ->find($ord->status) : null;

        /** @var \OrdersTypesModel $status */
        $type = isset($ord->type) ? Proxy::init()->getEntityManager()->getRepository(\OrdersTypesModel::class)
            ->find($ord->type) : null;

        /** @var \OrdersPimpayModel | null $pimpayStatus */
        $pimpayStatus = Proxy::init()->getEntityManager()->getRepository(\OrdersPimpayModel::class)
            ->find($ord->pimpay_status ?? \OrdersPimpayModel::DEFAULT_ID);

        $delivTime1 = $delivTime2 = null;

        if (isset($ord->delivery_time1) && preg_match('/^\d{1,2}:\d{2}$/', $ord->delivery_time1)) {
            $delivTime1 = \DateTime::createFromFormat('H:i', $ord->delivery_time1);
        }

        if (isset($ord->delivery_time2) && preg_match('/^\d{1,2}:\d{2}$/', $ord->delivery_time2)) {
            $delivTime2 = \DateTime::createFromFormat('H:i', $ord->delivery_time2);
        }

        $order
            ->setClient($client)
            ->setPimpayStatus($pimpayStatus)
            ->setStatus($status)
            ->setType($type)
            ->setOldId($ord->id)
            ->setAdmNotes($ord->adm_notes ?? null)
            ->setAgentAct($ord->agent_act ?? null)
            ->setAgentId($ord->agent_id ?? null)
            ->setAgentVact($ord->agent_vact ?? null)
            ->setAktId($ord->akt_id ?? null)
            ->setBillId($ord->bill_id ?? null)
            ->setBrand($ord->brand ?? null)
            ->setCallOption($ord->call_option ?? null)
            ->setCard($ord->card ?? null)
            ->setCardType($ord->card_type ?? null)
            ->setCargoLift($ord->cargo_lift ?? null)
            ->setChangeDate(isset($ord->change_date) ? \DateTime::createFromFormat('Y-m-d H:i:s', $ord->change_date) : null)
            ->setChangeOption($ord->change_option ?? null)
            ->setChangeText($ord->change_text ?? null)
            ->setChweightflag($ord->chweightflag ?? null)
            ->setCourCid($ord->cour_cid ?? null)
            ->setCourierId($ord->courier_id ?? null)
            ->setDateAdd($ord->date_add ?? null)
            ->setDeliveryDate(isset($ord->delivery_date) ? \DateTime::createFromFormat('Y-m-d', $ord->delivery_date) : null)
            ->setDeliveryTime($ord->delivery_time)
            ->setDeliveryTime1($delivTime1)
            ->setDeliveryTime2($delivTime2)
            ->setDocsOption($ord->docs_option ?? null)
            ->setDocsReturnOption($ord->docs_return_option ?? null)
            ->setDressFittingOption($ord->dress_fitting_option ?? null)
            ->setInnerN($ord->inner_n ?? null)
            ->setIsComplect($ord->is_complect ?? null)
            ->setIsPacked($ord->is_packed ?? null)
            ->setIsoh($ord->isoh ?? null)
            ->setLabelOption($ord->label_option ?? null)
            ->setLiftingOption($ord->lifting_option ?? null)
            ->setManagerId($ord->manager_id ?? null)
            ->setNdsPriceClient($ord->nds_price_client ?? null)
            ->setNp($ord->np ?? null)
            ->setOpenOption($ord->open_option ?? null)
            ->setOrderId($ord->order_id ?? null)
            ->setOrderWeight($ord->order_weight ?? null)
            ->setOrdercall($ord->ordercall ?? null)
            ->setOrderplace($ord->orderPlace ?? null)
            ->setOtkazmark($ord->otkazmark ?? null)
            ->setPReason($ord->p_reason ?? null)
            ->setCReason($ord->c_reason ?? null)
            ->setPartialOption($ord->partial_option ?? null)
            ->setPartnerAct($ord->partner_act ?? null)
            ->setPimpSend($ord->pimp_send ?? null)
            ->setPlacesCount($ord->places_count ?? null)
            ->setRegBillId($ord->reg_bill_id ?? null)
            ->setShk($ord->shk ?? null)
            ->setSms($ord->sms ?? null)
            ->setTargetContacts($ord->target_contacts ?? null)
            ->setTargetName($ord->target_name ?? null)
            ->setTargetNotes($ord->target_notes ?? null)
            ->setUpdateDateFlag($ord->update_date_flag ?? null);
        return $order;
    }

    /**
     * @param \Address $address
     * @param \stdClass $ord
     * @return \Address
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function buildAddress(\Address $address, \stdClass $ord)
    {
        /** @var \AddressTypesModel $addrType */
        $addrType = Proxy::init()->getEntityManager()->getRepository(\AddressTypesModel::class)
            ->find(\AddressTypesModel::DEFAULT_ID);
        $latLon = preg_replace('/,{1}\s*/', '|', $ord->latitude);
        $coords = explode('|', $latLon);

        $address
            ->setBuilding($ord->building)
            ->setCity($ord->city)
            ->setCorpus($ord->corpus)
            ->setDomofon($ord->domofon)
            ->setFloor($ord->floor)
            ->setLatitude($coords[1] ?? null)
            ->setLongitude($coords[0] ?? null)
            ->setMoMkad((int)$ord->mo_mkad)
            ->setMoPunktId($ord->mo_punkt_id)
            ->setOffice($ord->office)
            ->setPostAddr($ord->post_addr)
            ->setPostIndex($ord->post_index)
            ->setPvzId($ord->pvz_id)
            ->setRegCity($ord->reg_city)
            ->setRegFulladdr($ord->reg_fulladdr)
            ->setStreet($ord->street)
            ->setType($addrType)
            ->setZoneId($ord->zone_id);
        Proxy::init()->getEntityManager()->persist($address);
        Proxy::init()->getEntityManager()->flush();
        return $address;
    }

    /**
     * @param \OrdersBills $orderBills
     * @param \stdClass $ord
     * @return \OrdersBills
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function buildOrderBill(\OrdersBills $orderBills, \stdClass $ord)
    {
        $orderBills
            ->setAgentCost($ord->agent_cost)
            ->setChangeOs($ord->change_os)
            ->setChangeWeight($ord->change_weight)
            ->setDimensionSide1($ord->dimension_side1)
            ->setDimensionSide2($ord->dimension_side2)
            ->setDimensionSide3($ord->dimension_side3)
            ->setOs($ord->os)
            ->setPdCall($ord->pd_call)
            ->setPdChange($ord->pd_change)
            ->setPdDocs($ord->pd_docs)
            ->setPdDocsReturn($ord->pd_docs_return)
            ->setPdDop($ord->pd_dop)
            ->setPdDopCompl($ord->pd_dop_compl)
            ->setPdDopPack($ord->pd_dop_pack)
            ->setPdDopStrah($ord->pd_dop_strah)
            ->setPdDopVozvrat($ord->pd_dop_vozvrat)
            ->setPdEq($ord->pd_eq)
            ->setPdKo($ord->pd_ko)
            ->setPdLabel($ord->pd_label)
            ->setPdSms($ord->pd_sms)
            ->setPdTar($ord->pd_tar)
            ->setPriceClient($ord->price_client)
            ->setPriceClientDelivery($ord->price_client_delivery)
            ->setPriceCourier($ord->price_courier)
            ->setPriceDelivery($ord->price_delivery)
            ->setPriceGoods($ord->price_goods)
            ->setSum2p($ord->sum2p);
        Proxy::init()->getEntityManager()->persist($orderBills);
        Proxy::init()->getEntityManager()->flush();
        return $orderBills;
    }

    /**
     * @param \OrdersSettings $orderSettings
     * @param \stdClass $ord
     * @return \OrdersSettings
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function buildOrderSettings(\OrdersSettings $orderSettings, \stdClass $ord)
    {

        $orderSettings
            ->setReciepientName($ord->reciepient_name)
            ->setDocDescription($ord->doc_description);
        Proxy::init()->getEntityManager()->persist($orderSettings);
        Proxy::init()->getEntityManager()->flush();
        return $orderSettings;

    }

    /**
     * @param array $counts
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public
    function saveOrdersCount(array $counts)
    {
        $idList = [];
        foreach ($counts as $c) {
            if (!is_object($c)) continue;
            $idList[] = $c->client_id;
        }
        $idRow = implode(',', $idList);
        $query = 'SELECT  * FROM orders_count WHERE client_id IN (' . $idRow . ')';
        $ordCounts = Proxy::init()->getConnection()->query($query)->fetchAll();
        $ordCids = array_column($ordCounts, 'client_id');
        $ordIds = array_column($ordCounts, 'id');
        $combine = array_combine($ordCids, $ordIds);
        foreach ($counts as $c) {
            if (isset($combine[$c->client_id])) {
                /** @var \OrdersCount $ordersCount */
                $ordersCount = Proxy::init()->getEntityManager()->getRepository(\OrdersCount::class)
                    ->find($combine[$c->client_id]);
                $ordersCount
                    ->setClientId($c->client_id)
                    ->setOrdersQty($c->orders_qty)
                    ->setLastId($c->last_id);
            } else {
                $ordersCount = (new \OrdersCount())
                    ->setClientId($c->client_id)
                    ->setOrdersQty($c->orders_qty)
                    ->setLastId($c->last_id);
            }
            Proxy::init()->getEntityManager()->persist($ordersCount);
        }
        Proxy::init()->getEntityManager()->flush();
    }

    /**
     * @param \Orders[] $orders
     * @param \Porders[] $porders
     * @param \Marks[] $marks
     * @return array
     */
    public function buildStatusV3($orders, $porders, $marks)
    {

        /** @var \Porders[] $porsdersSorted */
        $porsdersSorted = [];
        foreach ($porders as $pord) {
            $porsdersSorted[$pord->getOrderId()] = $pord;
        }

        /** @var \Marks[] $marksSorted */
        $marksSorted = [];
        foreach ($marks as $mark) {
            $marksSorted[$mark->getId()] = $mark;
        }

        $ordersArray = [];
        foreach ($orders as $ord) {
            $podstatus = isset($porsdersSorted[$ord->getOrderId()]) ?
                $porsdersSorted[$ord->getOrderId()]->getPodstatus()->getPodstatus() : null;


            /** \Orders $ord */
            if ($ord->getStatus()->getId() == \OrdersStatusModel::STATUS_PARTIAL_FAILURE) { // && is_array($ord->getGoods())
                /** @var \Goods[] $goodsArray */
                $goodsArray = $this->buildGoodsV3($ord->getGoods());
            }

            $cancelReason = null;

            if (in_array($ord->getStatus()->getId(), [\OrdersStatusModel::STATUS_REJECTION, \OrdersStatusModel::STATUS_CANCEL])) {
                $markId = (int)$ord->getCReason();
                $cancelReason = isset($marksSorted[$markId]) ? $marksSorted[$markId]->getMarkDescr() : null;
            }

            $ordersArray[$ord->getOrderId()] = [
                self::ORDER_ORDER_ID => $ord->getOrderId(),
                self::ORDER_INNER_ID => $ord->getInnerN(),
                self::ORDER_SHK => $ord->getShk(),
                self::ORDER_DELIVERY_DATE => $ord->getDeliveryDate()->format('Y-m-d H:i:s'),
                self::ORDER_STATUS => $ord->getStatus()->getId(),
                self::ORDER_ORDER_WEIGHT => round((float)$ord->getOrderWeight(), 2),
                self::ORDER_PRICE_DELIVERY => (float)$ord->getOrderBill()->getPriceDelivery(),
                self::ORDER_PRICE_DELIVERY => (float)$ord->getOrderBill()->getPriceClient(),
                self::ORDER_CHANGE => $ord->getChangeDate()->format('Y-m-d H:i:s'),
                self::ORDER_RECEPIENT => $ord->getOrderSettings()->getReciepientName(),
                self::ORDER_ORDER_GOODS => $goodsArray ?? null,
                self::ORDER_PODSTATUS => $podstatus,
                self::ORDER_CANCEL_REASON => $cancelReason,
                self::ORDER_UPDATE_DATE_FLAG => $ord->getUpdateDateFlag(),
                self::ORDER_UPDATE_DATE_REASON => null,
                self::ORDER_BILL_ID => $ord->getBillId(),
                self::ORDER_PAYMENT_TYPE => $ord->getCard() == 1 ? 1 : 2
            ];
        }
        return $ordersArray;
    }

    /**
     * @param \Goods $goodsCollection
     * @return array
     */
    private function buildGoodsV3($goodsCollection): array
    {
        $goodsArray = [];
        foreach ($goodsCollection as $goods) {
            $goodsArray[] = [
                self::GOODS_ID => $goods->getId(),
                self::GOODS_ARTNAME => $goods->getDescription(),
                self::GOODS_WEIGHT => $goods->getWeight(),
                self::GOODS_COUNT_WEIGHT => $goods->getCountWeight(),
                self::GOODS_COUNT => $goods->getCount(),
                self::GOODS_VOC_ID => null,
                self::GOODS_ARTICUL => $goods->getArticle(),
                self::GOODS_PRICE => (float)$goods->getPrice(),
                self::GOODS_IS_CANCEL => $goods->getIsCancel(),
                self::GOODS_ORDER_ID => $goods->getOrderId(),
                self::GOODS_ZORDER_ID => null,
                self::GOODS_ON_WARE => null,
                self::GOODS_GSTATUS => null,
                self::GOODS_V_AKT_ID => $goods->getVAktId(),
                self::GOODS_SA_VACT_ID => null,
                self::GOODS_NDS => $goods->getGoodsNdsType()->getNds()
            ];
        }
        return $goodsArray;
    }

}