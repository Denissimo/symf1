<?php

namespace App\Api;

use App\Api\Response\Builder;
use App\Helpers\Output;
use App\Proxy;
use App\Api\Fields as Api;

class Process
{

    /**
     * @param array $orders
     * @param string $class
     * @param int|null $useId
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function processUpdate(array $orders, string $class, $useId = null)
    {
        return $this->saveUpdateOrders($orders, $class, $useId);
    }


    /**
     * @param \stdClass $lists
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    public function processLists(\stdClass $lists)
    {
        $res['clients'] = $this->processClients($lists->clients);
        $res['pvz'] = $this->processPvz($lists->pvz);
        $res['stocks'] = $this->processStock($lists->stocks);
        Proxy::init()->getEntityManager()->flush();
        return $res;
    }

    /**
     * @param array $clients
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    private function processClients(array $clients)
    {

        $sortedClients = $this->sortedArray($clients, \ClientSettings::CLIENT_ID);
        /** @var \ClientSettings[] $clientsAll */
        $clientsAll = \ClientSettings::all();

        foreach ($clientsAll as $client) {
            $clientId = $client->getClientId();

            if (isset($sortedClients[$clientId])) {
                $clientNewData = $sortedClients[$clientId];
                $client
                    ->setIsOff($clientNewData->is_off)
                    ->setApikey($clientNewData->apikey)
                    ->setActive($clientNewData->active);
                Proxy::init()->getEntityManager()->persist($client);
                unset($sortedClients[$clientId]);
            }
        }

        foreach ($sortedClients as $cli) {
            $newClient = (new \ClientSettings())
                ->setClientId($cli->client_id)
                ->setIsOff($cli->is_off)
                ->setApikey($cli->apikey)
                ->setActive($cli->active);
            Proxy::init()->getEntityManager()->persist($newClient);
        }
        return [];
    }

    /**
     * @param array $pvz
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    private function processPvz(array $pvz)
    {

        $sortedPvz = $this->sortedArray($pvz, \Model::ID);
        /** @var \Pvz[] $pvzAll */
        $pvzAll = \Pvz::all();

        foreach ($pvzAll as $p) {
            $id = $p->getId();

            if (isset($sortedPvz[$id])) {
                $pvzNewData = $sortedPvz[$id];
                $currentPvz = (new Builder())->buildPvz($p, $pvzNewData);
                Proxy::init()->getEntityManager()->persist($currentPvz);
                unset($sortedPvz[$id]);
            }
        }

        foreach ($sortedPvz as $pv) {
            $newPvz = (new Builder())->buildPvz((new \Pvz()), $pv);
            Proxy::init()->getEntityManager()->persist($newPvz);
        }
        return [];
    }

    /**
     * @param array $stocks
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    private function processStock(array $stocks)
    {

        $sortedStocks = $this->sortedArray($stocks, \Model::ID);
        /** @var \ZordersStocksModels[] $stocksAll */
        $stocksAll = \ZordersStocksModels::all();

        foreach ($stocksAll as $stock) {
            $id = $stock->getId();

            if (isset($sortedStocks[$id])) {
                $stockNewData = $sortedStocks[$id];
                $currentStock = (new Builder())->buildStock($stock, $stockNewData);
                Proxy::init()->getEntityManager()->persist($currentStock);
                unset($sortedStocks[$id]);
            }
        }

        foreach ($sortedStocks as $st) {
            $newStock = (new Builder())->buildStock((new \ZordersStocksModels()), $st);
            Proxy::init()->getEntityManager()->persist($newStock);
        }
        return [];
    }

    /**
     * @param array $array
     * @param string $column
     * @return array
     */
    private function sortedArray(array $array, string $column): array
    {
        $columnArray = array_column($array, $column);
        return array_combine($columnArray, $array);
    }

    /**
     * @param array $orders
     * @param string $class
     * @param int|null $useId
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    private function saveUpdateOrders(array $orders, string $class, $useId = null)
    {
        $lostUpdateTime = new \DateTime();
        $firstUpdateTime = \DateTime::createFromFormat('Y-m-d H:i:s', reset($orders)->updated);
        Proxy::init()->getLogger()->addWarning('firstUpdateTime: ' . \GuzzleHttp\json_encode($firstUpdateTime));
        if (isset($orders[0]->data_last_id)) {
            $optionsLog = (new \OptionsLog())
                ->setOrderId($orders[0]->data_last_id)
                ->setUpd(\DateTime::createFromFormat('Y-m-d H:i:s', $orders[0]->data_update_time))
                ->setSqt($orders[0]->data_sql);
            Proxy::init()->getEntityManager()->persist($optionsLog);
        }

        foreach ($orders as $ord) {
            $order = (new Loader())->loadOrderByOid($ord->id);
            if (is_object($order)) {
                $oid = $order->getId();
                $goods = (new Loader())->loadGoodsByOrder($order);
                isset($ord->goods) ? (new Checker())->goodsCompare($ord->goods, $goods, $order) : null;
                $address = (new Builder())->buildAddress($order->getAddress(), $ord);
                $orderBill = (new Builder())->buildOrderBill($order->getOrderBill(), $ord);
                $orderSettings = (new Builder())->buildOrderSettings($order->getOrderSettings(), $ord);
                $currentOrder = (new Builder())->buildOrder($order, $ord);
                $ordersPvz = (new Builder())->buildOrdersPvz($currentOrder, $ord);
                if (is_object($ordersPvz)) {
                    Proxy::init()->getEntityManager()->persist($ordersPvz);
                }

                $currentOrder
                    ->setAddress($address)
                    ->setOrderBill($orderBill)
                    ->setOrderSettings($orderSettings);


                Proxy::init()->getEntityManager()->persist($currentOrder);

                $this->saveHistory(
                    $currentOrder,
                    \OrdersHistoryTypesModel::UPDATE_ID,
                    'order',
                    \GuzzleHttp\json_encode($ord)
                );
            } else {
                (new Builder())->saveOrders([$ord]);
                $oid = '-';
            }
            Proxy::init()->getLogger()->addWarning($oid . ' >> ' . $ord->id . ' >> ' . $ord->updated);

        }
        Proxy::init()->getEntityManager()->flush();
        $endUpdateTime = \DateTime::createFromFormat('Y-m-d H:i:s', end($orders)->updated);
        Proxy::init()->getLogger()->addWarning('endUpdateTime: ' . \GuzzleHttp\json_encode($endUpdateTime));
        $endOrderId = (int)end($orders)->id;
        $finalUpdateTime = $endUpdateTime < $lostUpdateTime ? $endUpdateTime : $lostUpdateTime;
        Proxy::init()->getLogger()->addWarning('finalUpdateTime: ' . \GuzzleHttp\json_encode($endUpdateTime));
        $finalOrderId = $endOrderId;
//        $useLastId = (int)($firstUpdateTime == $endUpdateTime && count($orders) > 1);
        if($firstUpdateTime == $endUpdateTime && count($orders) > 1) {
            $useLastId = 1;
            $resultUpdateTime = $endUpdateTime;
        } elseif($useId) {
            $useLastId = 0;
            $interval = new \DateInterval('PT1S');
            $resultUpdateTime = $endUpdateTime->add($interval);
        } else {
            $useLastId = 0;
            $resultUpdateTime = $endUpdateTime;
        }
        return [
            \Options::fields()[$class][\Options::UPDATE] =>  $resultUpdateTime,
            \Options::fields()[$class][\Options::LAST_ID] => $finalOrderId,
            \Options::fields()[$class][\Options::USE_ID] => $useLastId
        ];
    }

    /**
     * @param array $porders
     * @param int|null $useId
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function saveUpdatePorders(array $porders, $useId = null)
    {
        $firstDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', reset($porders)->datetime);
        foreach ($porders as $pord) {
            $porder = (new Loader())->loadByOid(\Porders::class, $pord->id);
                $currentOrder = (new Builder())->buildPorder(
                    is_object($porder) ? $porder : new \Porders(),
                    $pord
                );
                Proxy::init()->getEntityManager()->persist($currentOrder);
        }
        $endDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', end($porders)->datetime);
        if($firstDateTime == $endDateTime && count($porders) > 1) {
            $useLastId = 1;
            $resultUpdateTime = $endDateTime;
        } elseif($useId) {
            $useLastId = 0;
            $interval = new \DateInterval('PT1S');
            $resultUpdateTime = $endDateTime->add($interval);
        } else {
            $useLastId = 0;
            $resultUpdateTime = $endDateTime;
        }
        $finalPorderId = (int)end($porders)->id;
        Proxy::init()->getEntityManager()->flush();
        return [
            \Options::PORDERS_UPDATE => $resultUpdateTime,
            \Options::PORDERS_LAST_ID => $finalPorderId,
            \Options::PORDERS_USE_ID => $useLastId
        ];
    }


    /**
     * @param array $zorders
     * @param null $useId
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function saveUpdateZorders(array $zorders, $useId = null)
    {
        $firstDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', reset($zorders)->updated);
        foreach ($zorders as $zord) {
            $zorder = (new Loader())->loadByOid(\Zorders::class, $zord->id);
            $currentOrder = (new Builder())->buildZorder(
                is_object($zorder) ? $zorder : new \Zorders(),
                $zord
            );
            Proxy::init()->getEntityManager()->persist($currentOrder);
        }
        $endDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', end($zorders)->updated);
        if($firstDateTime == $endDateTime && count($zorders) > 1) {
            $useLastId = 1;
            $resultUpdateTime = $endDateTime;
        } elseif($useId) {
            $useLastId = 0;
            $interval = new \DateInterval('PT1S');
            $resultUpdateTime = $endDateTime->add($interval);
        } else {
            $useLastId = 0;
            $resultUpdateTime = $endDateTime;
        }

        $finalZorderId = (int)end($zorders)->id;
        Proxy::init()->getEntityManager()->flush();
        return [
            \Options::ZORDERS_UPDATE => $resultUpdateTime,
            \Options::ZORDERS_LAST_ID => $finalZorderId,
            \Options::ZORDERS_USE_ID => $useLastId
        ];
    }


    /**
     * @param \Orders $order
     * @param int $type
     * @param string | null $param
     * @param string | null $value
     * @throws \Exception
     * @throws \Doctrine\ORM\ORMException
     */
    public function saveHistory(\Orders $order, int $type, $param = null, $value = null)
    {
        /** @var \OrdersHistoryTypesModel $ordersHirtoryType */
        $ordersHirtoryType = Proxy::init()->getEntityManager()
            ->getRepository(\OrdersHistoryTypesModel::class)->find($type);
        $ordersHirtory = (new \OrdersHistory())
            ->setDatetime(new \DateTime())
            ->setParameter($param)
            ->setValue($value)
            ->setType($ordersHirtoryType)
            ->setOid($order)
            ->setClient($order->getClient());
        Proxy::init()->getEntityManager()->persist($ordersHirtory);

    }

}