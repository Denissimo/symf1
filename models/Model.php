<?php

use \App\Proxy;
use Doctrine\Common\Collections\Criteria;

abstract class Model
{

    /**
     * первичный ключ модели
     *
     * @return string
     */
    static public function getPrimaryKey()
    {
        return 'id';
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    static public function getRepository()
    {
        return Proxy::init()->getEntityManager()->getRepository(static::class);
    }

    /**
     * вернет все записи из бд
     *
     * @return array|object[]
     */
    static public function all()
    {
        return static::getRepository()->findAll();
    }

    /**
     * вернет результат по условию Criteria или id
     *
     * @param Criteria|int $query
     * @return \Doctrine\Common\Collections\Collection|object|null
     * @throws Exception
     */
    static public function find($query)
    {
        if ($query instanceof Criteria) {
            return static::getRepository()->matching($query);
        }
        $query = (int)$query;
        if (!$query) {
            throw new \App\Exceptions\BadResponseException('Invalid query model: ' . static::class);
        }
        return static::getRepository()->find($query);
    }

    /**
     * если результат пустой, выкинет исключение
     *
     * @param Criteria|int $query
     * @return \Doctrine\Common\Collections\Collection|object|null
     * @throws Exception
     */
    static public function findOrFail($query)
    {
        $result = static::find($query);
        if (!$result || !$result->count()) {
            throw new \App\Exceptions\NotFoundRecord('Not found');
        }
        return $result;
    }
}