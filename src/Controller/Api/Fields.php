<?php

namespace App\Controller\Api;


Interface Fields
{
    const
        KEY = 'key',
        ORDERS_QTY = 'orders_qty',
        DATE_START = 'date_start',
        DATE_END = 'date_end',
        CLIENT_ID = 'client_id',
        CLIENT_ID_LIST = 'client_id_list',
        CLIENT_ID_FROM = 'client_id_from',
        CLIENT_ID_TO = 'client_id_to',
        LIMIT_START = 'limit_start',
        LIMIT_END = 'limit_end';

    const
        FORM_PARAMS = 'form_params';

    const
        GET = 'GET',
        POST = 'POST',
        PUT = 'PUT',
        DELETE = 'DELETE'
    ;
}