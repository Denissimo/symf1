<?php

use \App\Proxy;
use Doctrine\Common\Collections\Criteria;

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
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    static public function getRepository()
    {
        return static::getEntity()->getRepository(static::class);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
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
     * @return \Doctrine\Common\Collections\Collection|object|null
     * @throws \App\Exceptions\BadResponseException
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
            throw new \App\Exceptions\BadResponseException('Invalid query model: ' . static::class);
        }
        return static::getRepository()->find($query);
    }

    /**
     * если результат пустой, выкинет исключение
     *
     * @param Criteria|int $query
     * @return \Doctrine\Common\Collections\Collection|object|static
     * @throws Exception
     */
    static public function findOrFail($query)
    {
        $result = static::find($query);
<<<<<<< HEAD
        if (!$result || ($result instanceof \Doctrine\Common\Collections\Collection && !$result->count())) {
            throw new \App\Exceptions\NotFoundRecord('Not found', 404);
=======
        if (!$result || !$result->count()) {
            throw new Exception('Запись не найдена', 403);
>>>>>>> step 3
        }
        return $result;
    }
}