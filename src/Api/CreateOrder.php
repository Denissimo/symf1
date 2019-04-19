<?php


namespace App\Api;

use App\Api\Request\Validator;
use App\Providers\Headers;
use App\Helpers\Output;

class CreateOrder
{

    const
        FROM = 'from',
        TO = 'to';

    const
        KEY = 'key',
        INNER_N = 'inner_n',
        DELIVERY_DATE = 'delivery_date',
        DELIVERY_TIME = 'delivery_time',
        DELIVERY_TIME1 = 'delivery_time1',
        DELIVERY_TIME2 = 'delivery_time2',
        TARGET_NAME = 'target_name',
        TARGET_CONTACTS = 'target_contacts',
        TARGET_NOTES = 'target_notes',
        ORGANIZATION_NAME = 'organization_name',
        SECOND_PHONE = 'second_phone',
        OS = 'os',
        NP = 'np',
        PRICE_CLIENT = 'price_client',
        PRICE_CLIENT_DELIVERY = 'price_client_delivery',
        PRICE_CLIENT_DELIVERY_NDS = 'price_client_delivery_nds',
        ORDER_WEIGHT = 'order_weight',
        PLACES_COUNT = 'places_count',
        BARCODES = 'barcodes',
        SHK = 'shk',
        BRAND = 'brand',
        DIMENSION_SIDE1 = 'dimension_side1',
        DIMENSION_SIDE2 = 'dimension_side2',
        DIMENSION_SIDE3 = 'dimension_side3',
        CITY = 'city',
        MO_PUNKT_ID = 'mo_punkt_id',
        ADDR = 'addr',
        SMS = 'sms',
        OPEN_OPTION = 'open_option',
        CALL_OPTION = 'call_option',
        DOCS_OPTION = 'docs_option',
        PARTIAL_OPTION = 'partial_option',
        DRESS_FITTING_OPTION = 'dress_fitting_option',
        LIFTING_OPTION = 'lifting_option',
        CARGO_LIFT = 'cargo_lift',
        FLOOR = 'floor',
        CHANGE_OPTION = 'change_option',
        CHANGE_TEXT = 'change_text',
        CHANGE_WEIGHT = 'change_weight',
        CHANGE_OS = 'change_os',
        GOODS = 'goods';

    public $fields = [
        self::KEY,
        self::INNER_N,
        self::DELIVERY_DATE,
        self::DELIVERY_TIME,
        self::DELIVERY_TIME1,
        self::DELIVERY_TIME2,
        self::TARGET_NAME,
        self::TARGET_CONTACTS,
        self::TARGET_NOTES,
        self::ORGANIZATION_NAME,
        self::SECOND_PHONE,
        self::OS,
        self::NP,
        self::PRICE_CLIENT,
        self::PRICE_CLIENT_DELIVERY,
        self::PRICE_CLIENT_DELIVERY_NDS,
        self::ORDER_WEIGHT,
        self::PLACES_COUNT,
        self::BARCODES,
        self::SHK,
        self::BRAND,
        self::DIMENSION_SIDE1,
        self::DIMENSION_SIDE2,
        self::DIMENSION_SIDE3,
        self::CITY,
        self::MO_PUNKT_ID,
        self::ADDR,
        self::SMS,
        self::OPEN_OPTION,
        self::CALL_OPTION,
        self::DOCS_OPTION,
        self::PARTIAL_OPTION,
        self::DRESS_FITTING_OPTION,
        self::LIFTING_OPTION,
        self::CARGO_LIFT,
        self::FLOOR,
        self::CHANGE_OPTION,
        self::CHANGE_TEXT,
        self::CHANGE_WEIGHT,
        self::CHANGE_OS,
        self::GOODS
    ];

    private $required = [
        self::KEY,
        self::INNER_N,
        self::DELIVERY_DATE,
        self::DELIVERY_TIME,
        self::TARGET_NAME,
        self::TARGET_CONTACTS,
        self::OS,
        self::NP,
        self::PRICE_CLIENT,
        self::PRICE_CLIENT_DELIVERY,
        self::ORDER_WEIGHT,
        self::PLACES_COUNT,
        self::DIMENSION_SIDE1,
        self::DIMENSION_SIDE2,
        self::DIMENSION_SIDE3,
        self::ADDR,
        self::SMS,
        self::OPEN_OPTION,
        self::CALL_OPTION,
        self::DOCS_OPTION,
        self::PARTIAL_OPTION,
        self::DRESS_FITTING_OPTION,
        self::LIFTING_OPTION,
        self::GOODS
    ];

    public $delivery_date;
    public $delivery_time;
    public $delivery_time1;
    public $delivery_time2;
    public $city;
    public $mo_punkt_id;
    public $floor;
    public $target_name;
    public $target_contacts;
    public $target_notes;
    public $price_client;
    public $os;
    public $dimension_side1;
    public $dimension_side2;
    public $dimension_side3;
    public $price_client_delivery;
    public $np;
    public $sms;
    public $inner_n;
    public $brand;
    public $shk;
    public $order_weight;
    public $open_option;
    public $call_option;
    public $places_count;
    public $docs_option;
    public $partial_option;
    public $dress_fitting_option;
    public $lifting_option;
    public $cargo_lift;
    public $change_option;
    public $change_text;
    public $change_os;
    public $change_weight;

    private $deliveryTimes = [
        1 => [self::FROM => '10:00', self::TO => '14:00'],
        2 => [self::FROM => '10:00', self::TO => '18:00'],
        3 => [self::FROM => '14:00', self::TO => '18:00'],
        4 => [self::FROM => '18:00', self::TO => '22:00']
    ];

    /**
     * CreateOrder constructor.
     * @param Headers $request
     */
    public function __construct(Headers $request)
    {
        (new Validator())->validateRequiredFields(
            $request,
            $this->required,
            true
        );

        $this->setParams($request);
    }

    /**
     * @param Headers $request
     */
    private function setParams(Headers $request)
    {
        $this->delivery_date = $request->request->get('delivery_date');
        $this->delivery_time = $request->request->get('delivery_time');
        $this->delivery_time1 = $this->deliveryTimes[$this->delivery_time][self::FROM];
        $this->delivery_time2 = $this->deliveryTimes[$this->delivery_time][self::TO];;
        $this->city = $request->request->get('city');
        $this->mo_punkt_id = $request->request->get('mo_punkt_id');
        $this->floor = $request->request->get('floor');
        $this->target_name = $request->request->get('target_name');
        $this->target_contacts = $request->request->get('target_contacts');
        $this->target_notes = $request->request->get('target_notes');
        $this->price_client = $request->request->get('price_client');
        $this->os = $request->request->get('os');
        $this->dimension_side1 = $request->request->get('dimension_side1');
        $this->dimension_side2 = $request->request->get('dimension_side2');
        $this->dimension_side3 = $request->request->get('dimension_side3');
        $this->price_client_delivery = $request->request->get('price_client_delivery');
        $this->np = $request->request->get('np');
        $this->sms = $request->request->get('sms');
        $this->inner_n = $request->request->get('inner_n');
        $this->brand = $request->request->get('brand');
        $this->shk = $request->request->get('shk');
        $this->order_weight = $request->request->get('order_weight');
        $this->open_option = $request->request->get('open_option');
        $this->call_option = $request->request->get('call_option');
        $this->places_count = $request->request->get('places_count');
        $this->docs_option = $request->request->get('docs_option');
        $this->partial_option = $request->request->get('partial_option');
        $this->dress_fitting_option = $request->request->get('dress_fitting_option');
        $this->lifting_option = $request->request->get('lifting_option');
        $this->cargo_lift = $request->request->get('cargo_lift');
        $this->change_option = $request->request->get('change_option');
        $this->change_text = $request->request->get('change_text');
        $this->change_os = $request->request->get('change_os');
        $this->change_weight = $request->request->get('change_weight');

    }


}