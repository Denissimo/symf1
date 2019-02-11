<?php

namespace App\Helpers;


class Output
{
    public static function echo($data, bool $die = null){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        $die ? die : null;
    }
}