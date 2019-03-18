<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 05.02.2019
 * Time: 15:42
 */

namespace App\Api\Request;

use App\Api\Fields as Api;


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
        self::DATE_START => '2002-01-01',
        self::LIMIT_START => '0',
        self::LIMIT_END => '20',
    ];

    /**
     * @param array $orderStat
     * @param array $get
     * @return $this
     * @throws \Exception
     */
    public function set(array $orderStat, array $get)
    {
        $this->clientId = $orderStat[self::CLIENT_ID];
        $this->dateStart = $get[self::DATE_START] ?? self::$defaults[self::DATE_START];
        $this->dateEnd =  $get[self::DATE_END] ?? '2020-12-31'; //(new \DateTime())->format('Y-m-d')->;
        $this->limitStart = $get[self::LIMIT_START] ?? $orderStat[self::QTY] ?? self::$defaults[self::LIMIT_START];
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

    /**
     * @param string $clientId
     * @return Unit
     */
    public function setClientId(string $clientId): Unit
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @param string $dateStart
     * @return Unit
     */
    public function setDateStart(string $dateStart): Unit
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * @param string $dateEnd
     * @return Unit
     */
    public function setDateEnd(string $dateEnd): Unit
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * @param string $limitStart
     * @return Unit
     */
    public function setLimitStart(string $limitStart): Unit
    {
        $this->limitStart = $limitStart;
        return $this;
    }

    /**
     * @param string $limitEnd
     * @return Unit
     */
    public function setLimitEnd(string $limitEnd): Unit
    {
        $this->limitEnd = $limitEnd;
        return $this;
    }
}