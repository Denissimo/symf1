<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 05.02.2019
 * Time: 15:42
 */

namespace App\Controller\Api\Request;

use App\Controller\Api\Fields as Api;


class Unit implements Api
{
    /** @var string */
    private $clientId;

    /** @var string */
    private $dateStart;

    /** @var string */
    private $dateEnd;

    /** @var string */
    private $limitStart;

    /** @var string */
    private $limitEnd;

    private static $defaults = [
        self::DATE_START => '2015-01-01',
        self::LIMIT_START => '1',
        self::LIMIT_END => '10',
    ];

    /**
     * @param string $clientId
     * @param array $get
     * @return $this
     * @throws \Exception
     */
    public function set(string $clientId, array $get)
    {
        $this->clientId = $clientId;
        $this->dateStart = $get[self::DATE_START] ?? self::$defaults[self::DATE_START];
        $this->dateEnd =  $get[self::DATE_END] ?? (new \DateTime())->format('Y-m-d');
        $this->limitStart = $get[self::LIMIT_START] ?? self::$defaults[self::LIMIT_START];
        $this->limitEnd = $get[self::LIMIT_END] ?? self::$defaults[self::LIMIT_END];
        return $this;
    }


    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getDateStart(): string
    {
        return $this->dateStart;
    }

    /**
     * @return string
     */
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }

    /**
     * @return string
     */
    public function getLimitStart(): string
    {
        return $this->limitStart;
    }

    /**
     * @return string
     */
    public function getLimitEnd(): string
    {
        return $this->limitEnd;
    }

}