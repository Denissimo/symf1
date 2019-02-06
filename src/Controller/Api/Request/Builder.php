<?php

namespace App\Controller\Api\Request;

use Symfony\Component\HttpFoundation\Request;

class Builder
{
    /** @var Unit[] */
    private $unitlist;

    /**
     * @param array $clientIds
     * @param Request $request
     * @return $this
     * @throws \Exception
     */
    public function set(
        array $clientIds,
        Request $request
    )
    {
        foreach ($clientIds as $id)
        {
            $this->unitlist[] = (new Unit)->set($id, $request->query->all());
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