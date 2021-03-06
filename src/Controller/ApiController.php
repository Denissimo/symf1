<?php

namespace App\Controller;

use App\Api\LaraProvider;
use App\Api\Process;
use App\Exceptions\BadResponseException;
use App\Exceptions\InactiveCliendException;
use App\Exceptions\InvalidRequestAgrs;
use App\Exceptions\MalformedRequestException;
use App\Exceptions\OrdersListEmptyResponseException;
use App\Wrappers\Order;
use App\Wrappers\ZOrder;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Proxy;
use App\Twig\Render;
use App\Api\Fields as Api;
use App\Api\Loader;
use App\Api\Request\Builder;
use App\Api\Request\Validator as RequestValidator;
use App\Api\Response\Builder as ResponseBuidser;
use App\Api\Response\Validator;
use App\Exceptions\MalformedResponseException;
use App\Exceptions\MalformedApiKeyException;
use App\Helpers\Output;
use App\Api\CreateOrder;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;



class ApiController extends BaseController implements Api
{
    /**
     * Метод с авторизацией
     *
     * @Route("/is_auth")
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function isAuthMethod()
    {
        return (new Render())->render([
            Render::CONTENT => 'Hello ' . $this->getUser()->getName()
        ]);
    }


    /**
     * метод без авторизации
     *
     * @Route("/is_not_auth")
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function isNotAuthMethod()
    {
        return (new Render())->render([
            Render::CONTENT => 'YES'
        ]);
    }

    /**
     * @Route("/api/v1/getStatusv2")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function statusV3()
    {
        $content = 'OK';
        try {
            /** @var \LogTypesModel $typeModel */
            $typeModel = \LogTypesModel::find(\LogTypesModel::API_STATUS_V2_ID);

            (new RequestValidator())->validateRequiredFields(self::getRequest(), [Api::KEY]);
            /** @var \ClientSettings $client */
            $client = Proxy::init()->getEntityManager()->getRepository(\ClientSettings::class)
                ->findOneBy([\ClientSettings::API_KEY => self::getRequest()->get(Api::KEY)]);
            (new RequestValidator())->validateApiKey(
                $client,
                'Incorrect Api Key'
            );
            (new RequestValidator())->validateClientActive($client);
            (new RequestValidator())->validateRequiredFields(self::getRequest(), [Api::FIELD_FROM]);
            $dateFrom = \DateTime::createFromFormat(
                \Options::FORMAT,
                self::getRequest()->get(Api::FIELD_FROM)
            );
            (new RequestValidator())->validateNotBlank($dateFrom, 'Incorrect field: ' . Api::FIELD_FROM);

            $dateTo = self::getRequest()->get(Api::FIELD_TO) != null ?
                \DateTime::createFromFormat(
                \Options::FORMAT,
                self::getRequest()->get(Api::FIELD_TO)
            ) : new \DateTime();

            (new RequestValidator())->validateNotBlank($dateTo, 'Incorrect field: ' . Api::FIELD_TO);

            $interval = date_diff($dateTo, $dateFrom);
            $dateDiff = $interval->format('%a');

            (new RequestValidator())->validateDateDiff($dateDiff, Api::LIMIT_DAYS_API_V3);

            $orders = (new Loader())->loadApiV3Orders(
                $client,
                $dateFrom,
                $dateTo
            );

            $porders = (new Loader())->loadPorders($orders);
            $marks = (new Loader())->loadMarks();

            $ordersData = (new ResponseBuidser())->buildStatusV3($orders, $porders, $marks);

        } catch (MalformedRequestException $e) {
            $this->logApi(
                $client ?? null,
                $typeModel ?? null,
                $this->loadErrorResultModel($e->getCode()),
                $e->getMessage()
            );

            return $this->error($e);

        } catch (MalformedApiKeyException $e) {
            $this->logApi(
                $client ?? null,
                $typeModel ?? null,
                $this->loadErrorResultModel($e->getCode()),
                $e->getMessage()
            );
            return $this->error($e);
        } catch (InactiveCliendException $e) {
            $this->logApi(
                $client ?? null,
                $typeModel ?? null,
                $this->loadErrorResultModel($e->getCode()),
                $e->getMessage()
            );
            return $this->error($e);
        } catch (\Exception $e) {
            $this->logApi(
                $client ?? null,
                $typeModel ?? null,
                $this->loadErrorResultModel($e->getCode()),
                $e->getMessage()
            );
            return $this->error($e);
        }

        /** @var \LogTypesModel $logType */
        $logType = \LogTypesModel::find(\LogTypesModel::API_STATUS_V2_ID);

        /** @var \LogResultModel $logResult */
        $logResult = \LogResultModel::find(HttpResponse::HTTP_OK);

        $this->logApi(
            $client,
            $logType,
            $logResult,
            \GuzzleHttp\json_encode($ordersData)
        );

        return $this->success($ordersData);
    }

    /**
     *
     * @Route("/api/v1/getStatus", methods={"GET"})
     *
     * @return HttpResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getStatus()
    {
        try {
            $innerId = self::getRequest()->get(Api::INNER_N, 0);
            $orderId = self::getRequest()->get(Api::ORDER_ID, 0);
            /** @var \LogTypesModel $typeModel */
            $typeModel = \LogTypesModel::find(\LogTypesModel::API_STATUS_V1_ID);

            // если нет ни одно или переданны оба значения
            // мы принимаем только одно значение
            if ((!$innerId && !$orderId) || ($innerId && $orderId)) {
                throw new InvalidRequestAgrs(sprintf("Error request: One field required %s or %s", Api::INNER_N, Api::ORDER_ID));
            }

            $client = $this->getClientSettings();

            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq(\Zorders::CLIENT, $client));

            if (!empty($innerId)) {
                $criteria->andWhere(Criteria::expr()->eq(\Orders::INNER_N, $innerId));
            } else {
                $criteria->andWhere(Criteria::expr()->eq(\Orders::ORDER_ID, $orderId));
            }

            $order = \Orders::findOrFail($criteria)->first();

            $wrapperOrder = new Order($order);
            if ($client->getClientId() === 1584 || $client->getClientId() === 1489) {
                $wrapperOrder->findUpdateDateReason();
            }

            $options = [];
            if ($client->getClientId() === 1391) {
                $options['options'] = [
                    'reciepient_name' => $wrapperOrder->reciepient,
                    'doc_description' => $order->getOrderSettings()->getDocDescription(),
                    'delivery_time' => $order->getChangeDate()->getTimestamp(),
                ];
            }

            /** @var \LogResultModel $successModel */
            $successModel = \LogResultModel::find(HttpResponse::HTTP_OK);
            $this->logApi(
                $client,
                $typeModel,
                $successModel,
                \GuzzleHttp\json_encode($wrapperOrder)
            );
            return $this->success($wrapperOrder, $options);
        } catch (\Exception $e) {
            $this->logApi(
                $client ?? null,
                $typeModel ?? null,
                $this->loadErrorResultModel($e->getCode()),
                $e->getMessage()
            );
            return $this->error($e);
        }
    }

    /**
     * @param int $code
     * @return Collection|\LogResultModel|object|null
     */
    private function loadErrorResultModel(int $code)
    {
        try {
            return \LogResultModel::find($code);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param \ClientSettings  | null $client
     * @param \LogTypesModel | null $type
     * @param \LogResultModel | null $result
     * @param string | null $response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    private function logApi($client, $type, $result, $response)
    {
        $logsApi = (new \LogsApi())
            ->setClient($client)
            ->setIp(self::getRequest()->getClientIp())
            ->setRequest(\GuzzleHttp\json_encode(self::getRequest()->query->all()))
            ->setRequestType($type)
            ->setResult($result)
            ->setResponse($response);
        Proxy::init()->getEntityManager()->persist($logsApi);
        Proxy::init()->getEntityManager()->flush();
    }

    /**
     *
     * @Route("/api/v1/getZStatus", methods={"GET"})
     *
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getZStatus()
    {
        try {
            $innerId = self::getRequest()->get(Api::INNER_N, 0);
            $orderId = self::getRequest()->get(Api::ZORDER_ID, 0);

            // если нет ни одно или переданны оба значения
            // мы принимаем только одно значение
            if ((!$innerId && !$orderId) || ($innerId && $orderId)) {
                throw new InvalidRequestAgrs(sprintf("Не заполнено одно из полей %s или %s", Api::INNER_N, Api::ZORDER_ID));
            }

            $client = $this->getClientSettings();

            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq(\Zorders::CLIENT, $client));

            if (!empty($innerId)) {
                $criteria->andWhere(Criteria::expr()->eq(\Zorders::INNER, $innerId));
            } else {
                $criteria->andWhere(Criteria::expr()->eq(\Zorders::ID, $orderId));
            }

            $order = \Zorders::findOrFail($criteria)->first();
            return $this->success(new ZOrder($order));
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * @Route("/api/v1/confirmOrder", methods={"POST"})
     *
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function confirmOrder()
    {
        try {
            $innerId = self::getRequest()->get(Api::INNER_N, 0);
            $orderId = self::getRequest()->get(Api::ORDER_ID, 0);

            // если нет ни одно или переданны оба значения
            // мы принимаем только одно значение
            if ((!$innerId && !$orderId) || ($innerId && $orderId)) {
                throw new InvalidRequestAgrs(sprintf("Не заполнено одно из полей %s или %s", Api::INNER_N, Api::ORDER_ID));
            }

            $client = $this->getClientSettings();

            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq(\Orders::CLIENT, $client));

            if (!empty($innerId)) {
                $criteria->andWhere(Criteria::expr()->eq(\Orders::INNER_N, $innerId));
            } else {
                $criteria->andWhere(Criteria::expr()->eq(\Orders::ORDER_ID, $orderId));
            }

            /** @var \Orders $order */
            $order = \Orders::findOrFail($criteria)->first();

            // если ордер уже активирован
            if ($order->getStatus() !== 1) {
                throw new InvalidRequestAgrs('Ордер ' . $order->getInnerN() . ' уже подтвержден!');
            }

            if ($order->getType()->getId() === 2) {
                // забор из ПВЗ
                // @todo ВАЛИДАЦИЯ ПВЗ
            }

            $status = \OrdersStatusModel::findOrFail(2);
            $order->setStatus($status);
            if (in_array($client->getId(), [1511, 1850, 2]) ||
                ($order->getType()->getId() !== 2 && $order->getDeliveryDate()->format('Y-m-d') <= date('Y-m-d'))) {
                $date = \DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('+1 day')));
                $order->setDeliveryDate($date);
            }

            \Orders::getEntity()->persist($order);
            \Orders::getEntity()->flush();

            return $this->success([
                'order_id' => $order->getOrderId(),
                'inner_id' => $order->getInnerN(),
                'Confirmed' => 'Ok'
            ]);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }


    /**
     * @Route("/api/v1/createOrder")
     * @return HttpResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function createOrder()
    {
        try {
            $create = new CreateOrder(self::getRequest());
            $client = $this->getClientSettings();
            $create->setClientId($client);
            $post = self::getRequest()->request->all();

//            $post = (new RequestValidator())->validateCreateOrder($post, true);

            $criteriaDuplicate = Criteria::create()
                ->where(Criteria::expr()->eq(\Orders::INNER_N, $post[Api::INNER_N]))
                ->andWhere(Criteria::expr()->eq(\Orders::CLIENT, $client));

            $order = \Orders::find($criteriaDuplicate)->first();

            if ($order && !$client->getId() !== 1489) {
                throw new InvalidRequestAgrs('Duplicate order: ' . $post[Api::INNER_N]);
            }

            $criteriaLast = Criteria::create()
                ->where(Criteria::expr()->eq(\Orders::CLIENT, $client))
                ->andWhere(Criteria::expr()->eq(\Orders::CLIENT, $client)
                )
                ->orderBy([\Orders::ID => Criteria::DESC]);

            /** @var \Orders|null $orderLast */
            $orderLast = \Orders::find($criteriaLast)->first();

            $regexpHex = '/^'.\Orders::PREFIX.$client->getClientId().'\-([0-9A-Fa-f]+)\-.+$/';
            $regexpDec = '/^'.\Orders::PREFIX.$client->getClientId().'\-([0-9]+)$/';

            if(is_null($orderLast)) {
                $newNumber = 1;
            }elseif(preg_match($regexpHex, $orderLast->getOrderId(), $matches)) {
                $newNumber = hexdec($matches[1]);
                $newNumber++;
            }elseif(preg_match($regexpDec, $orderLast->getOrderId(), $matches)) {
                $newNumber = $matches[1];
                $newNumber++;
            } else {
                $newNumber = 1;
            }

            $lara = new LaraProvider();
            $addr = $lara->findAddress($create->addr);
            $geoId = $addr->toArray()[0]->id;
            $create->setGeoId($geoId);
            $regionCode = $addr->toArray()[0]->region_code;
//            Output::echo($addr->toArray()[0]->region_code, true);

            $newHex = dechex($newNumber);
            $orderId = \Orders::PREFIX . $client->getClientId(). '-' . $newHex . '-' . $regionCode;
            $create->setOrderId($orderId);

//            $newOrder = (new ResponseBuidser())->buildOrder(new \Orders(), $create);
//            (new ResponseBuidser())->saveOrders([$create]);

//            $address = (new ResponseBuidser())->buildAddress(new \Address(), $create);

            $order = (new ResponseBuidser())->buildOrder(new \Orders(), $create);
            Proxy::init()->getEntityManager()->persist($order);
            Proxy::init()->getEntityManager()->flush();

//            Output::echo($order->getId(), true);
            $orderBill = (new ResponseBuidser())->buildOrderBill(new \OrdersBills(), $create);
            $orderSettings = (new ResponseBuidser())->buildOrderSettings(new \OrdersSettings(), $create);

            $order
                ->setOrderBill($orderBill)
                ->setOrderSettings($orderSettings);

            Proxy::init()->getEntityManager()->persist($order);
            Proxy::init()->getEntityManager()->flush();

            (new Process())->saveHistory($order,
                \OrdersHistoryTypesModel::CREATE_ID,
                'order',
                \GuzzleHttp\json_encode($create)
            );

            isset($create->goods) ? (new ResponseBuidser())->saveGoods((array)$create->goods, $order) : null;
            Proxy::init()->getEntityManager()->flush();
            $link = 'http://cab.logsis.ru/responders/label_p?im=1&id' . $order->getOrderId() . '=' .
                $order->getOrderId();
            $response = [
                'order_id' => $order->getOrderId(),
                'price_client' => $create->price_client,
                'price_delivery' => 0, 'inner_track' =>$create->inner_n,
                'label' => $link
            ];


            return $this->success([$response]);

        } catch (MalformedRequestException $e){
            return $this->error($e);
        } catch (\Exception $e) {
//            throw $e;
//            dd($e);
            return $this->error($e);
        }
    }

    protected function createNewOrder()
    {

    }

}