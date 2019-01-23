<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;


return ConsoleRunner::createHelperSet(
    EntityManager::create(
        [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'dbname' => 'kabudasay',
            'charset' => 'utf8',
        ],
        Setup::createAnnotationMetadataConfiguration(
            ['C:\OSpanel\OSPanel\domains\symf1\models'],
            true,
            null,
            null,
            false
        )
    )
);
