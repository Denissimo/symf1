<?php

namespace App\Controller\Api\Response;

use App\Controller\Api\Structure as Fields;
use App\Proxy;

class Builder
{
    /**
     * @param array $orders
     * @throws \Doctrine\ORM\ORMException
     */
    public function buildOrders(array $orders)
    {
        $fields = Fields::$fields;
        foreach ($orders as $ord) {
//            $address = $this->buildAddress($ord);
//            $orderBills = $this->buildOrderBills($ord);
            $orderSettings = $this->buildOrderSettings($ord);
            var_dump($orderSettings->getId());
            die;

        }
    }

    /**
     * @param \stdClass $ord
     * @return \Address
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function buildAddress(\stdClass $ord)
    {
        $addrType = Proxy::init()->getEntityManager()->getRepository(\AddressTypesModel::class)
            ->find(\AddressTypesModel::DEFAULT_ID);

        $address = (new \Address())
            ->setBuilding($ord->building ?? null)
            ->setCity($ord->city ?? null)
            ->setCorpus($ord->corpus ?? null)
            ->setDomofon($ord->domofon ?? null)
            ->setFloor($ord->floor ?? null)
            ->setLatitude($ord->latitude ?? null)
            ->setLongitude($ord->longitude ?? null)
            ->setMoMkad($ord->mo_mkad ?? null)
            ->setMoPunktId($ord->mo_punkt_id ?? null)
            ->setOffice($ord->office ?? null)
            ->setPostAddr($ord->post_addr ?? null)
            ->setPostIndex($ord->post_index ?? null)
            ->setPvzId($ord->pvz_id ?? null)
            ->setRegCity($ord->reg_city ?? null)
            ->setRegFulladdr($ord->reg_fulladdr ?? null)
            ->setStreet($ord->street ?? null)
            ->setType($addrType)
            ->setZoneId($ord->zone_id ?? null);
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
    private function buildOrderBills(\stdClass $ord)
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
    private function buildOrderSettings(\stdClass $ord)
    {
        $orderSettings = (new \OrdersSettings())
            ->setReciepientName($ord->reciepient_name)
            ->setDocDescription($ord->doc_description)
            ;
        Proxy::init()->getEntityManager()->persist($orderSettings);
        Proxy::init()->getEntityManager()->flush();
        return $orderSettings;

    }

}