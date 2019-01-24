<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;


return ConsoleRunner::createHelperSet(
    EntityManager::create(
        [
            'driver' => 'pdo_mysql',
            'host' => 'kabudasay.beget.tech',
            'user' => 'kabudasay_core',
            'password' => 'arg0navt12$',
            'dbname' => 'kabudasay_core',
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
