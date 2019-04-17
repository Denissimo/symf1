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

    /**
     * @param string | null $sdate
     * @param bool $full
     * @return bool|\DateTime|null
     */
    public static function date($sdate, bool $full = false)
    {
        $format = $full ? 'Y-m-d H:i:s' : 'Y-m-d';
        $date = \DateTime::createFromFormat($format, $sdate);
        return $date && $date->format('Y') > 0 ? $date : null;
    }
}