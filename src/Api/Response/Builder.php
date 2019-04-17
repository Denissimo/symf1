<?php

namespace App\Api\Response;

use App\Api\Process;
use App\Api\Structure as Fields;
use App\Helpers\Convert;
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
     * @return bool|\DateTime
     * @throws \Exception
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function process(array $results)
    {
        $currentChangeDate = new \DateTime();
        foreach ($results as $orders) {
            $orderChangeDate = $this->saveOrders((array)$orders);
            $currentChangeDate = ($orderChangeDate < $currentChangeDate) ? $orderChangeDate : $currentChangeDate;
        }
        return $currentChangeDate;
    }


    /**
     * @param array $orders
     * @return bool|\DateTime
     * @throws \Exception
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveOrders(array $orders)
    {
        $duplicates = (array)$this->checkDuplicateOrders($orders);
        $currentChangeDate = new \DateTime();
        foreach ($orders as $ord) {
            if (isset($ord->id) && !in_array($ord->id, $duplicates)) {
                $address = $this->buildAddress(new \Address(), $ord);
                $orderBill = $this->buildOrderBill(new \OrdersBills(), $ord);
                $orderSettings = $this->buildOrderSettings(new \OrdersSettings(), $ord);
                $order = $this->buildOrder(new \Orders(), $ord);
                $ordersPvz = $this->buildOrdersPvz($order, $ord);
                if (is_object($ordersPvz)) Proxy::init()->getEntityManager()->persist($ordersPvz);
                $orderChangeDate = \DateTime::createFromFormat('Y-m-d H:i:s', $ord->updated);
                $currentChangeDate = ($orderChangeDate < $currentChangeDate) ? $orderChangeDate : $currentChangeDate;

                $order
                    ->setAddress($address)
                    ->setOrderBill($orderBill)
                    ->setOrderSettings($orderSettings);

                (new Process())->saveHistory($order,
                    \OrdersHistoryTypesModel::IMPORT_ID,
                    'order',
                    \GuzzleHttp\json_encode($ord)
                );
                Proxy::init()->getEntityManager()->persist($order);
                isset($ord->goods) ? $this->saveGoods((array)$ord->goods, $order) : null;
            }
        }
        Proxy::init()->getEntityManager()->flush();
        return $currentChangeDate;
    }

    /**
     * @param \Orders $order
     * @param \stdClass $ord
     * @return \Doctrine\Common\Collections\Collection|object|\OrdersPvz|null
     * @throws \Exception
     */
    public function buildOrdersPvz(\Orders $order, \stdClass $ord)
    {
        $pregPvzId = preg_match('/^\(?([0-9]+)\)?.*$/', $ord->pvz_id, $pvzIdMatch);
        if ($pregPvzId) {
            /** @var \Pvz $pvz */
            $pvz = \Pvz::find((int)$pvzIdMatch[1]);
            if ($pvz == null ) $pvz = \Pvz::find(\OrdersPvz::TEST_ID);
            $ordersPvzExists = \OrdersPvz::exists($order, $pvz);
            if (is_object($ordersPvzExists)) {
                $ordersPvz = $ordersPvzExists;
            } else {
                $ordersPvz = (new \OrdersPvz())
                    ->setOrder($order)
                    ->setPvz($pvz);
            }
            return $ordersPvz;
        } else {
            return null;
        }

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
        /** @var \GoodsStatusModel $goodStatus */
        $goodStatus = Proxy::init()->getEntityManager()->getRepository(\GoodsStatusModel::class)
            ->find($good->gstatus);

        /** @var \NdsType | null $ndsType */
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
                        Criteria::expr()->eq(\ClientSettings::CLIENTID, $ord->client_id)
                    )
                    ->setMaxResults(1)

            )->current();

        /** @var \OrdersStatusModel $status */
        $status = isset($ord->status) ? Proxy::init()->getEntityManager()->getRepository(\OrdersStatusModel::class)
            ->find($ord->status) : null;

        /** @var \OrdersTypesModel $type */
        $type = isset($ord->type) ? Proxy::init()->getEntityManager()->getRepository(\OrdersTypesModel::class)
            ->find($ord->type) : null;

        $delivTime1 = $delivTime2 = null;

        if (isset($ord->delivery_time1) && preg_match('/^\d{1,2}:\d{2}$/', $ord->delivery_time1)) {
            $delivTime1 = \DateTime::createFromFormat('H:i', $ord->delivery_time1);
        }

        if (isset($ord->delivery_time2) && preg_match('/^\d{1,2}:\d{2}$/', $ord->delivery_time2)) {
            $delivTime2 = \DateTime::createFromFormat('H:i', $ord->delivery_time2);
        }

        $order
            ->setClient($client)
            ->setChangeWeight($ord->change_weight)
            ->setStatus($status)
            ->setType($type)
            ->setOldId($ord->id)
            ->setAdmNotes($ord->adm_notes ?? null)
            ->setAgentId($ord->agent_id ?? null)
            ->setAktId($ord->akt_id ?? null)
            ->setBillId($ord->bill_id ?? null)
            ->setBrand($ord->brand ?? null)
            ->setChangeDate(isset($ord->change_date) ? \DateTime::createFromFormat('Y-m-d H:i:s', $ord->change_date) : null)
            ->setUpdated(isset($ord->updated) ? \DateTime::createFromFormat('Y-m-d H:i:s', $ord->updated) : null)
            ->setCourCid($ord->cour_cid ?? null)
            ->setCourierId($ord->courier_id ?? null)
            ->setDateAdd(isset($ord->date_add) ? \DateTime::createFromFormat('Y-m-d', $ord->date_add) : null)
            ->setDeliveryDate(isset($ord->delivery_date) ? \DateTime::createFromFormat('Y-m-d', $ord->delivery_date) : null)
            ->setDeliveryTime($ord->delivery_time)
            ->setDeliveryTime1($delivTime1)
            ->setDeliveryTime2($delivTime2)
            ->setInnerN($ord->inner_n ?? null)
            ->setManagerId($ord->manager_id ?? null)
            ->setOrderId($ord->order_id ?? null)
            ->setOrderWeight($ord->order_weight ?? null)
            ->setOrderplace($ord->orderPlace ?? null)
            ->setOtkazmark($ord->otkazmark ?? null)
            ->setPReason($ord->p_reason ?? null)
            ->setCReason($ord->c_reason ?? null)
            ->setPlacesCount($ord->places_count ?? null)
            ->setRegBillId($ord->reg_bill_id ?? null)
            ->setShk($ord->shk ?? null)
            ->setTargetContacts($ord->target_contacts ?? null)
            ->setTargetName($ord->target_name ?? null)
            ->setTargetNotes($ord->target_notes ?? null)
            ->setUpdateDateFlag($ord->update_date_flag ?? null)
        ;
        return $order;
    }


    /**
     * @param \Porders $porder
     * @param \stdClass $pord
     * @return \Porders
     * @throws \Exception
     */
    public function buildPorder(\Porders $porder, \stdClass $pord)
    {
        /** @var \PordersPodstatusModel $podstatus */
        $podstatus = isset($pord->podstatus) ? Proxy::init()->getEntityManager()
            ->getRepository(\PordersPodstatusModel::class)
            ->find($pord->podstatus) : null;
        $enddate = Convert::date($pord->enddate);
        $datetime = Convert::date($pord->datetime, true);

        $order = \Orders::find(
            Criteria::create()
                ->where(Criteria::expr()->eq(\Orders::ORDER_ID, $pord->order_id))
        )->first();


        $porder
            ->setOldId($pord->id)
            ->setPodstatus($podstatus)
            ->setOrder($order)
            ->setOrderId($pord->order_id)
            ->setAtar($pord->atar)
            ->setAnp($pord->anp)
            ->setAus($pord->aus)
            ->setBillId($pord->bill_id)
            ->setEnddate($enddate)
            ->setDatetime($datetime)
        ;

        return $porder;
    }

    /**
     * @param \Zorders $zorder
     * @param \stdClass $zord
     * @return \Zorders
     * @throws \Exception
     */
    public function buildZorder(\Zorders $zorder, \stdClass $zord)
    {
        /** @var \ZordersTypesModel $type */
        $type =  \ZordersTypesModel::find($zord->type_id);

        /** @var \ZordersStatusModel $status */
        $status = \ZordersStatusModel::find($zord->sts);

        /** @var \ZordersStocksModels $stock */
        $stock = \ZordersStocksModels::find($zord->sklad_id);

        /** @var \ZordersStocksOurModel $stockOur */
        $stockOur = \ZordersStocksOurModel::find($zord->sklad_num);

        /** @var \ZordersVaktPartStatusModel $vaktId */
        $vaktId = \ZordersVaktPartStatusModel::find($zord->vakt_id);

        /** @var \ClientSettings $client */
        $client = \ClientSettings::find(
            Criteria::create()
                ->where(Criteria::expr()->eq(\ClientSettings::CLIENTID, $zord->client_id))
        )->first();


        $zorder
            ->setOldId($zord->id)
            ->setType($type)
            ->setDate(Convert::date($zord->date))
            ->setClient($client)
            ->setCourierId($zord->courier_id)
            ->setStockOur($stockOur)
            ->setInnerCli($zord->inner_cli)
            ->setMoKladrId($zord->mo_kladr_id)
            ->setStock($stock)
            ->setZoneId($zord->zone_id)
            ->setInner($zord->inner)
            ->setTime1($zord->time1)
            ->setTime2($zord->time2)
            ->setZcomments($zord->zcomments)
            ->setStatus($status)
            ->setIsPay($zord->is_pay)
            ->setZpvzId($zord->zpvz_id)
            ->setZprice($zord->zprice)
            ->setBillId($zord->bill_id)
            ->setWeight($zord->weight)
            ->setCap($zord->cap)
            ->setCrCost($zord->cr_cost)
            ->setCarType($zord->car_type)
            ->setPerenos($zord->perenos)
            ->setPerenosMark($zord->perenos_mark)
            ->setChangeDate(Convert::date($zord->change_date, true))
            ->setVozvratmark($zord->vozvratmark)
            ->setPlacesCount($zord->places_count)
            ->setVaktPart($zord->vakt_part)
            ->setVaktPartStatus($vaktId);

        return $zorder;
    }

    /**
     * @param \Pvz $pvz
     * @param \stdClass $stdPvz
     * @return \Pvz
     */
    public function buildPvz(\Pvz $pvz, \stdClass $stdPvz)
    {
        $pvz
            ->setOldId($stdPvz->id)
            ->setMxmId($stdPvz->mxm_id)
            ->setName($stdPvz->name)
            ->setCode($stdPvz->code)
            ->setContactName($stdPvz->contact_name)
            ->setContactNumber($stdPvz->contact_number)
            ->setContactMail($stdPvz->contact_mail)
            ->setDognum($stdPvz->dognum)
            ->setDogdate($stdPvz->dogdate)
            ->setPathdesc($stdPvz->pathDesc)
            ->setWorktime($stdPvz->workTime)
            ->setWorktime2($stdPvz->workTime2)
            ->setAddrfull($stdPvz->addrFull)
            ->setAddrstreet($stdPvz->addrStreet)
            ->setAddrhouse($stdPvz->addrHouse)
            ->setCoords($stdPvz->coords)
            ->setDeliverycost($stdPvz->deliveryCost)
            ->setRoute($stdPvz->route)
            ->setMoPunktId($stdPvz->mo_punkt_id)
            ->setPvzType($stdPvz->pvz_type)
            ->setPvzTar($stdPvz->pvz_tar)
            ->setPagentId($stdPvz->pagent_id)
            ->setInternal($stdPvz->internal)
            ->setNp($stdPvz->np)
            ->setTar($stdPvz->tar)
            ->setWeight((int)$stdPvz->weight)
            ->setStatus($stdPvz->status)
            ->setChdate($stdPvz->chdate ? \DateTime::createFromFormat('Y-m-d H:i:s', $stdPvz->chdate) : null)
            ->setComment($stdPvz->comment)
            ->setComment2($stdPvz->comment2)
            ->setPostalCode($stdPvz->postal_code)
            ->setRegionWithType($stdPvz->region_with_type)
            ->setAreaWithType($stdPvz->area_with_type)
            ->setCityWithType($stdPvz->city_with_type)
            ->setCityDistrictWithType($stdPvz->city_district_with_type)
            ->setSettlementWithType($stdPvz->settlement_with_type)
            ->setSettlementWithType($stdPvz->street_with_type)
            ->setHouse($stdPvz->house)
            ->setBlock($stdPvz->block)
            ->setParentCompany($stdPvz->parent_company)
            ->setEk($stdPvz->ek);
        return $pvz;
    }

    /**
     * @param \ZordersStocksModels $stock
     * @param \stdClass $stdStock
     * @return \ZordersStocksModels
     */
    public function buildStock(\ZordersStocksModels $stock, \stdClass $stdStock)
    {
        /** @var \ClientSettings $client */
        $client = Proxy::init()->getEntityManager()->getRepository(\ClientSettings::class)
            ->matching(
                Criteria::create()
                    ->where(
                        Criteria::expr()->eq(\ClientSettings::CLIENTID, $stdStock->client_id)
                    )
                    ->setMaxResults(1)

            )->current();

        $stock
            ->setOldId($stdStock->id)
            ->setName($stdStock->name)
            ->setAddr($stdStock->addr)
            ->setCity($stdStock->city)
            ->setLongtitude($stdStock->longtitude)
            ->setLatitude($stdStock->latitude)
            ->setClient($client)
            ->setComments($stdStock->comments)
            ->setContLico($stdStock->cont_lico)
            ->setContTel($stdStock->cont_tel)
            ->setTime($stdStock->time)
            ->setMoPunktId($stdStock->mo_punkt_id)
            ->setInnerN($stdStock->inner_n);
        return $stock;
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
        /** @var \OrdersPimpayModel | null $pimpayStatus */
        $pimpayStatus = Proxy::init()->getEntityManager()->getRepository(\OrdersPimpayModel::class)
            ->find($ord->pimpay_status ?? \OrdersPimpayModel::DEFAULT_ID);

        $orderBills
            ->setCard($ord->card ?? null)
            ->setCardType($ord->card_type ?? null)
            ->setPimpayStatus($pimpayStatus)
            ->setAgentCost($ord->agent_cost)
            ->setChangeOs($ord->change_os)
            ->setNdsPriceClient($ord->nds_price_client ?? null)
            ->setOs($ord->os)
            ->setPdDop($ord->pd_dop)
            ->setPdDopStrah($ord->pd_dop_strah)
            ->setPdEq($ord->pd_eq)
            ->setPdKo($ord->pd_ko)
            ->setPdTar($ord->pd_tar)
            ->setPimpSend($ord->pimp_send ?? null)
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
            ->setAgentAct($ord->agent_act ?? null)
            ->setAgentVact($ord->agent_vact ?? null)
            ->setCallOption($ord->call_option ?? null)
            ->setCargoLift($ord->cargo_lift ?? null)
            ->setChangeOption($ord->change_option ?? null)
            ->setChangeText($ord->change_text ?? null)
            ->setChweightflag($ord->chweightflag ?? null)
            ->setDocsOption($ord->docs_option ?? null)
            ->setDocsReturnOption($ord->docs_return_option ?? null)
            ->setDressFittingOption($ord->dress_fitting_option ?? null)
            ->setIsComplect($ord->is_complect ?? null)
            ->setIsPacked($ord->is_packed ?? null)
            ->setIsoh($ord->isoh ?? null)
            ->setLabelOption($ord->label_option ?? null)
            ->setLiftingOption($ord->lifting_option ?? null)
            ->setNp($ord->np ?? null)
            ->setOpenOption($ord->open_option ?? null)
            ->setOrdercall($ord->ordercall ?? null)
            ->setPartialOption($ord->partial_option ?? null)
            ->setPartnerAct($ord->partner_act ?? null)
            ->setSms($ord->sms ?? null)
            ->setDimensionSide1($ord->dimension_side1)
            ->setDimensionSide2($ord->dimension_side2)
            ->setDimensionSide3($ord->dimension_side3)
            ->setPdCall($ord->pd_call)
            ->setPdChange($ord->pd_change)
            ->setPdDocs($ord->pd_docs)
            ->setPdDocsReturn($ord->pd_docs_return)
            ->setPdDopCompl($ord->pd_dop_compl)
            ->setPdDopPack($ord->pd_dop_pack)
            ->setPdDopVozvrat($ord->pd_dop_vozvrat)
            ->setPdLabel($ord->pd_label)
            ->setPdSms($ord->pd_sms)
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
        /** @var \Orders $ord */
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
                self::ORDER_PRICE_CLIENT => (float)$ord->getOrderBill()->getPriceClient(),
                self::ORDER_CHANGE => $ord->getChangeDate()->format('Y-m-d H:i:s'),
                self::ORDER_RECEPIENT => $ord->getOrderSettings()->getReciepientName(),
                self::ORDER_ORDER_GOODS => $goodsArray ?? null,
                self::ORDER_PODSTATUS => $podstatus,
                self::ORDER_CANCEL_REASON => $cancelReason,
                self::ORDER_UPDATE_DATE_FLAG => $ord->getUpdateDateFlag(),
                self::ORDER_UPDATE_DATE_REASON => null,
                self::ORDER_BILL_ID => $ord->getBillId(),
                self::ORDER_PAYMENT_TYPE => $ord->getOrderBill()->getCard() == 1 ? 1 : 2
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
        /** @var \Goods $goods */
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