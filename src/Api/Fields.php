<?php

namespace App\Api;


Interface Fields
{
    const
        KEY = 'key',
        ORDERS_QTY = 'orders_qty',
        DATE_START = 'date_start',
        DATE_END = 'date_end',
        DATE_FROM = 'date_from',
        DATE_TO = 'date_to',
        FIELD_FROM = 'from',
        FIELD_TO = 'to',
        ID = 'id',
        QTY = 'qty',
        CLIENT_ID = 'client_id',
        CLIENT_ID_LIST = 'client_id_list',
        CLIENT_ID_FROM = 'client_id_from',
        CLIENT_ID_TO = 'client_id_to',
        LAST_ID = 'last_id',
        BIGGEST_ID = 'biggest_id',
        LIMIT_START = 'limit_start',
        LIMIT_END = 'limit_end',
        UPDATE_TIME = 'update_time',
        INNER_N = 'inner_n',
        ORDER_ID = 'order_id',
        ZERO = 0,
        ZORDER_ID = 'zorder_id',
        MO_PUNKT_ID = 'mo_punkt_id',
        CITY = 'city',
        ADDR = 'addr',
        GOODS = 'goods',
        NP = 'np',
        PRICE_CLIENT = 'price_client',
        OS = 'os',
        COUNT = 'count',
        PRICE = 'price',
        PRICE_CLIENT_DELIVERY = 'price_client_delivery';

    const
        FORM_PARAMS = 'form_params',
        DATE_FORMAT = 'Y-m-d',
        DATETIME_FORMAT = 'Y-m-d H:i:s';

    const
        GET = 'GET',
        POST = 'POST',
        PUT = 'PUT',
        DELETE = 'DELETE';

    const
        LIMIT_CLIENT_ORDERS_LOAD = 10,
        LIMIT_DAYS_API_V3 = 3;

    const
        MAX_LOAD_UPDATE_INTERVAL = 'PT12H',
        MAX_LOAD_ORDERS = 200;
}