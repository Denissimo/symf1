<?php


namespace App\Api;


use App\Api\Fields as Api;
use App\Exceptions\LaraEmptyResult;
use App\Exceptions\LaraErrorRequest;
use App\Proxy;
use Doctrine\Common\Collections\ArrayCollection;

class LaraProvider
{
    const KLADR = 'kladr';

    /** @var array */
    protected $apiKeys = [];

    /** @var string */
    protected $baseUrl = '';

    /**
     * LaraProvider constructor.
     */
    public function __construct()
    {
        $this->apiKeys = [
            self::KLADR => getenv('LARA_KLADR_API_TOKEN')
        ];
        $this->baseUrl = getenv('LARA_API_URL');
    }

    /**
     * поиск адресов по их строковым представлениям
     *
     * @param $address
     * @return ArrayCollection
     */
    public function findAddress($address)
    {
        if (!is_array($address)) {
            $address = [$address];
        }

        return $this->requestPost(self::KLADR, 'address/findByAddress', [
            'data' => \GuzzleHttp\json_encode($address)
        ]);
    }

    /**
     * поиск адреса по его id
     *
     * @param $id
     * @return \stdClass
     */
    public function getAddressId($id)
    {
        return $this->requestGet(self::KLADR, "address/getById/$id");
    }

    public function getAddressKladrId($kladrId)
    {
        return $this->requestGet(self::KLADR, "address/getByKladr/$kladrId");
    }

    /**
     * @param $url
     * @param array $data
     * @return ArrayCollection|\stdClass
     * @throws LaraErrorRequest
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function requestPost($type, $url, $data = [])
    {
        return $this->request($this->apiKeys[$type], Api::POST, $url, $data);
    }

    /**
     * @param $url
     * @param array $data
     * @return ArrayCollection|\stdClass
     * @throws LaraErrorRequest
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function requestGet($type, $url, $data = [])
    {
        return $this->request($this->apiKeys[$type], Api::GET, $url, $data);
    }

    /**
     * @param $type
     * @param $url
     * @param $data
     * @return ArrayCollection|\stdClass
     * @throws LaraErrorRequest
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request($key, $type, $url, $data)
    {
        try {
            $request = [
                'headers' => [
                    'Accept' => 'application/json, text/javascript, */*; q=0.01',
                    'X-Requested-With' => 'XMLHttpRequest',
                    'ApiToken' => $key
                ],
                'form_params' => $data
            ];

            $addressData = Proxy::init()->getHttpClient()->request($type, $this->baseUrl . $url, $request)->getBody()->getContents();

            $addressData = \GuzzleHttp\json_decode($addressData);
            if (empty($addressData) || empty($addressData->response)) {
                throw new LaraEmptyResult('Lara empty result');
            }

            if ($addressData->status !== 200) {
                throw new LaraErrorRequest($addressData->response, $addressData->status);
            }

            $result = $addressData->response;

            if (is_array($result)) {
                $result = new ArrayCollection($result);
            }

            return $result;
        } catch (\Exception $e) {
            throw new LaraErrorRequest($e->getMessage(), $e->getCode());
        }
    }
}