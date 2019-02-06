<?php

namespace App\Controller\Api;

use App\Controller\Api\Request\Unit;
use App\Proxy;
use GuzzleHttp;
use App\Controller\Api\Fields as Api;

class Client
{
    const
        API_PATH_ORDERS = 'change_with_db';

    /**
     * @param Unit $unit
     * @return string
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(Unit $unit)
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
                                Api::CLIENT_ID => $unit->getClientId(),
                                Api::DATE_START => $unit->getDateStart(),
                                Api::DATE_END => $unit->getDateEnd(),
                                Api::LIMIT_START => $unit->getLimitStart(),
                                Api::LIMIT_END => $unit->getLimitEnd()
                            ]
                    ]
                )->getBody()->getContents()
            );
    }


}