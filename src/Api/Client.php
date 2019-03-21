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
        API_PATH_ORDERS = 'change_with_db';

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
        Proxy::init()->getLogger()->addWarning(
            'Request: '.
            \GuzzleHttp\json_encode($request)
        );
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


        $andId = '';
        if( $request['last_id'])
        {
            $last_id = (int) $request['last_id'];
            $andId = ' AND o.id >= ' . $last_id;
        }

        $andIdBiggest = '';
        if( $request['biggest_id'])
        {
            $biggest_id = (int) $request['biggest_id'];
            $andIdBiggest = ' AND o.id <= ' . $biggest_id;
        }

        if( $request['update_time']) {
            $sql = 'SELECT o.*, o.status+0 as sts, type+0 as tp FROM ORDERS as o 
	LEFT JOIN CLIENT_SETTINGS cs ON o.client_id = cs.client_id
	WHERE cs.id IS NOT NULL AND
	o.client_id NOT IN (2, 238, 1356) AND 
o.change_date >= "' . $request['update_time'] . '" ' . $andId . $andIdBiggest . ' ORDER BY o.change_date ASC, o.id  ASC
  LIMIT ' . $request['limit_end'];
        }
        Proxy::init()->getLogger()->addWarning('update SQL: ' . $sql);





        Proxy::init()->getLogger()->addWarning('update Request: ' . \GuzzleHttp\json_encode($request));
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
}