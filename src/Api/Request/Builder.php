<?php

namespace App\Controller\Api\Request;

use Symfony\Component\HttpFoundation\Request;

class Builder
{
    const
        LIMIT_UPDATE = 100;

    /** @var Unit[] */
    private $unitlist;

    /**
     * @param array $orderStat
     * @param Request $request
     * @return $this
     * @throws \Exception
     */
    public function set(
        array $orderStat,
        Request $request
    )
    {
        foreach ($orderStat as $os)
        {
            $this->unitlist[] = (new Unit)->set($os, $request->query->all());
        }
        return $this;
    }

    /**
     * @return Unit[]
     */
    public function getUnitlist(): array
    {
        return $this->unitlist;
    }


}