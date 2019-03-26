<?php

namespace App\Api;

use App\Api\Request\Unit;
use App\Api\Request\Builder;
use App\Helpers\Output;
use App\Proxy;
use GuzzleHttp;
use App\Api\Fields as Api;
use Symfony\Component\HttpFoundation\Request;

class Client
{
    const
        API_PATH_ORDERS = 'change_with_db',
        API_PATH_LISTS = 'change_with_db_lists';

    /**
     * @param Unit[] $units
     * @return array
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function process($units)
    {
        foreach ($units as $unit) {
            $result [] = $this->sendLoadOrdersRequest($unit);
        }
        return $result;
    }

    /**
     * @param Unit $unit
     * @return array
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    private function sendLoadOrdersRequest(Unit $unit)
    {
        $request = [
            Api::FORM_PARAMS =>
                [
                    Api::KEY => getenv('cms_api_key'),
                    Api::CLIENT_ID => $unit->getClientId(),
                    Api::DATE_START => $unit->getDateStart(),
                    Api::DATE_END => $unit->getDateEnd(),
                    Api::LIMIT_START => $unit->getLimitStart(),
                    Api::LIMIT_END => $unit->getLimitEnd()
                ]
        ];
        return
            \GuzzleHttp\json_decode(
                Proxy::init()->getHttpClient()->request(
                    Api::POST,
                    getenv('cms_api_url1') . self::API_PATH_ORDERS,
                    $request
                )->getBody()->getContents()
            );
    }

    /**
     * @param string $client_id_list
     * @return array
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function sendOrdersQtyRequest(string $client_id_list)
    {
        return
            \GuzzleHttp\json_decode(
                Proxy::init()->getHttpClient()->request(
                    Api::POST,
                    getenv('cms_api_url1') . self::API_PATH_ORDERS,
                    [
                        Api::FORM_PARAMS =>
                            [
                                Api::KEY => getenv('cms_api_key'),
                                Api::CLIENT_ID_LIST => $client_id_list,
                                Api::ORDERS_QTY => true
                            ]
                    ]
                )->getBody()->getContents()
            );
    }

    /**
     * @param \DateTime $lastOrdersUpdateTime
     * @param int $lastOrderId
     * @param Request $get
     * @return mixed
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function sendOrdersUpdateRequest(\DateTime $lastOrdersUpdateTime, int $lastOrderId, int $biggestId, Request $get)
    {
        $request = [
            Api::KEY => getenv('cms_api_key'),
            Api::LIMIT_END => $get->query->all()[Api::LIMIT_END] ?? Builder::LIMIT_UPDATE,
            Api::UPDATE_TIME => $lastOrdersUpdateTime->format(\Options::FORMAT),
            Api::LAST_ID => $lastOrderId,
            Api::BIGGEST_ID => $biggestId
        ];

        return
            \GuzzleHttp\json_decode(
                Proxy::init()->getHttpClient()->request(
                    Api::POST,
                    getenv('cms_api_url1') . self::API_PATH_ORDERS,
                    [
                        Api::FORM_PARAMS =>
                            $request
                    ]
                )->getBody()->getContents()
            );
    }

    /**
     * @return mixed
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function sendListsUpdateRequest()
    {
        $request = [
            Api::KEY => getenv('cms_api_key')
        ];
        return
            \GuzzleHttp\json_decode(
                Proxy::init()->getHttpClient()->request(
                    Api::POST,
                    getenv('cms_api_url1') . self::API_PATH_LISTS,
                    [
                        Api::FORM_PARAMS =>
                            $request
                    ]
                )->getBody()->getContents()
            );
    }
}