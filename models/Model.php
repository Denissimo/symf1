<?php

use \App\Proxy;
use Doctrine\Common\Collections\Criteria;
use \Doctrine\Common\Persistence\ObjectRepository;
use \Doctrine\ORM\EntityRepository;
use \Doctrine\ORM\EntityManager;
use \Doctrine\Common\Collections\Collection;
use \App\Exceptions\BadResponseException;
use \App\Exceptions\NotFoundRecord;

abstract class Model
{
    const ID = 'id';

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
     * @return ObjectRepository|EntityRepository
     */
    static public function getRepository()
    {
        return static::getEntity()->getRepository(static::class);
    }

    /**
     * @return EntityManager
     */
    static public function getEntity()
    {
        return Proxy::init()->getEntityManager();
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
     * @param $query
     * @return Collection|object|null
     * @throws BadResponseException
     */
    static public function find($query)
    {
        if(!isset($query)) {
            return null;
        }

        if ($query instanceof Criteria) {
            return static::getRepository()->matching($query);
        }
        $query = (int)$query;
        if (!$query) {
            throw new BadResponseException('Invalid query model: ' . static::class);
        }
        return static::getRepository()->find($query);
    }

    /**
     * если результат пустой, выкинет исключение
     *
     * @param Criteria|int $query
     * @return Collection|object|static
     * @throws Exception
     */
    static public function findOrFail($query)
    {
        $result = static::find($query);
        if (!$result || ($result instanceof Collection && !$result->count())) {
            throw new NotFoundRecord('Not found', 404);
        }
        return $result;
    }
}