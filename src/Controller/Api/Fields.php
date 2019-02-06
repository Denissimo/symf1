<?php

namespace App\Controller\Api;


Interface Fields
{
    const
        KEY = 'key',
        DATE_START = 'date_start',
        DATE_END = 'date_end',
        CLIENT_ID = 'client_id',
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