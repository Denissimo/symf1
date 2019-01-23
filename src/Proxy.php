<?php

namespace App;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Session\Session;
//use Symfony\Component\Validator\Validator\RecursiveValidator as Validator;
use App\Validator;
use App\Cfg\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Security\Core\Authentication;

class Proxy
{

    const DEFAULT = 'default';

    /**
     * @var EntityManager
     */
    private static $entityManager;

    /**
     * @var Connection
     */
    private static $connection;

    /**
     * @var \Twig_Environment
     */
    private static $twigEnvironment;

    /**
     * @var Session
     */
    private static $session;

    /**
     * @var Validator
     */
    private static $validator;

    /**
     * @var Logger
     */
    private static $logger;


    private function __construct()
    {
        return $this;
    }

    /**
     * @return Proxy
     */
    public static function init()
    {
        return new self();
    }


    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return self::$entityManager;
    }

    /**
     * @return Connection
     */
    public function getConnecton()
    {
        return self::$connection;
    }

    /**
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     */
    public function initDoctrine()
    {
        self::$entityManager = EntityManager::create(
            Config::getDoctrineParams(),
            Setup::createAnnotationMetadataConfiguration(
                [".." . Config::getDoctrineOptions()[Config::FIELD_PATH]],
                Config::isProd(),
                null,
                null,
                false
            )
        );
        self::$connection = self::$entityManager->getConnection();
        return $this;
    }

    public function initTwig()
    {
        self::$twigEnvironment = new \Twig_Environment(
            new \Twig_Loader_Filesystem(".." . Config::getTwigPath()),
            Config::getTwigOptions()
        );
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwigEnvironment(): \Twig_Environment
    {
        return self::$twigEnvironment;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return self::$session;
    }

    public function startSession()
    {
        self::$session->isStarted() ? self::$session->start() : null;
        return $this;

    }
    /**
     * @return $this
     */
    public function initSession()
    {
        self::$session = new Session();
        return $this;
    }

    /**
     * @return $this
     */
    public function initValidator()
    {
        self::$validator = new Validator();
        return $this;
    }

    /**
     * @return Validator
     */
    public function getValidator(): Validator
    {
        return self::$validator;
    }

    /**
     * @param string $name
     * @param null $stream
     * @param null $level
     * @return $this
     * @throws \Exception
     */
    public function initLogger($name = Config::FIELD_DEFAULT, $stream = null, $level = null)
    {
        self::$logger = new Logger($name);
        self::$logger->pushHandler(
            new StreamHandler(
                $stream ?? Config::getLoggerPath().'log_'.(new \DateTime())->format('YmdHis').'_.txt',
                $level ?? Logger::WARNING
            )
        );
        return $this;
    }

    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return self::$logger;
    }


}