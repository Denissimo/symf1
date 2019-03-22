<?php

namespace App;

use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractProcessingHandler;

class MonologDBHandler extends AbstractProcessingHandler
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * MonologDBHandler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    /**
     * Called when writing to our database
     * @param array $record
     */
    protected function write(array $record)
    {
        $logEntry = new \LogsApi();
        if(isset($record[\LogsApi::IP])) $logEntry->setIp($record[\LogsApi::IP]);
        if(isset($record[\LogsApi::VALUE])) $logEntry->setValue($record[\LogsApi::VALUE]);
        if(isset($record[\LogsApi::CLIENT_ID])) $logEntry->setClient($record[\LogsApi::CLIENT_ID]);
        if(isset($record[\LogsApi::PARAM])) $logEntry->setParam($record[\LogsApi::PARAM]);
        if(isset($record[\LogsApi::REQUEST])) $logEntry->setRequest($record[\LogsApi::REQUEST]);
        if(isset($record[\LogsApi::REQUEST_TYPE])) $logEntry->setRequestType($record[\LogsApi::REQUEST_TYPE]);
        if(isset($record[\LogsApi::RESPONSE])) $logEntry->setResponse($record[\LogsApi::RESPONSE]);
        if(isset($record[\LogsApi::RESULT])) $logEntry->setResult($record[\LogsApi::RESULT]);
        if(isset($record[\LogsApi::USER_ID])) $logEntry->setUserId($record[\LogsApi::USER_ID]);

        $this->em->persist($logEntry);
        $this->em->flush();
    }
}