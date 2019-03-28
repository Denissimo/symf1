<?php

namespace App\Helpers;


class Convert
{
    /**
     * @param \stdClass $std
     * @return array
     */
    public static function stdToArray(\stdClass $std){
        return \GuzzleHttp\json_decode(
            \GuzzleHttp\json_encode($std),
            true
        );
    }
}