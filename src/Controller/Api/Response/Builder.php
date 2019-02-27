<?php

namespace App\Controller\Api\Response;

use App\Controller\Api\Structure as Fields;
use App\Proxy;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;
use App\Helpers\Output;

class Builder
{
    const
        TYPE = 'object',
        DEFAULT_ID = 1;

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
     */
    public function processUpdate(array $orders)
    {
        $this->saveUpdateOrders($orders);
        Output::echo('zz', 1);
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
            if (!in_array($ord->id, $duplicates)) {
                $address = $this->buildAddress($ord);
                $orderBill = $this->buildOrderBill($ord);
                $orderSettings = $this->buildOrderSettings($ord);
                $order = $this->buildOrder($ord);

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

    private function saveUpdateOrders(array $orders)
    {
        foreach ($orders as $ord) {
            Output::echo($ord->goods);
        }
    }

    /**
     * @param array $orders
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    private
    function checkDuplicateOrders(array $orders)
    {
        foreach ($orders as $key => $res) {
            if (!is_object($res)) continue;
            $idList[$key] = $res->id;
        }
        $idRow = implode(', ', $idList);
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
                $goodsAll[] = $this->buildGood($good)->setOrder($order);
                Proxy::init()->getEntityManager()->persist(current($goodsAll));
            }
        }
    }


    private
    function buildGood(\stdClass $good)
    {
        /** @var \GoodsStatusModel $client */
        $goodStatus = Proxy::init()->getEntityManager()->getRepository(\GoodsStatusModel::class)
            ->find($good->gstatus);

        /** @var \NdsType | null $client */
        $ndsType = $good->nds ? Proxy::init()->getEntityManager()->getRepository(\NdsType::class)
            ->find($good->nds) : null;

        return (new \Goods())
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
     * @param \stdClass $ord
     * @return \Orders
     */
    private
    function buildOrder(\stdClass $ord)
    {
        /** @var \ClientSettings $client */
        $client = Proxy::init()->getEntityManager()->getRepository(\ClientSettings::class)
            //->findBy([\ClientSettings::CLIENT_ID => $ord->client_id]);
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


        $order = (new \Orders())
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
            ->setChangeDate(\DateTime::createFromFormat('Y-m-d H:i:s', $ord->change_date) ?? null)
            ->setChangeOption($ord->change_option ?? null)
            ->setChangeText($ord->change_text ?? null)
            ->setChweightflag($ord->chweightflag ?? null)
            ->setCourCid($ord->cour_cid ?? null)
            ->setCourierId($ord->courier_id ?? null)
            ->setDateAdd($ord->date_add ?? null)
            ->setDeliveryDate(isset($ord->delivery_date) ? \DateTime::createFromFormat('Y-m-d', $ord->delivery_date) : null)
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
     * @param \stdClass $ord
     * @return \Address
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private
    function buildAddress(\stdClass $ord)
    {
        /** @var \AddressTypesModel $addrType */
        $addrType = Proxy::init()->getEntityManager()->getRepository(\AddressTypesModel::class)
            ->find(\AddressTypesModel::DEFAULT_ID);
        $latLon = preg_replace('/,{1}\s*/', '|', $ord->latitude);
        $coords = explode('|', $latLon);

        $address = (new \Address())
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
     * @param \stdClass $ord
     * @return \OrdersBills
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private
    function buildOrderBill(\stdClass $ord)
    {
        $orderBills = (new \OrdersBills())
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
     * @param \stdClass $ord
     * @return \OrdersSettings
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private
    function buildOrderSettings(\stdClass $ord)
    {

        $orderSettings = (new \OrdersSettings())
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

}