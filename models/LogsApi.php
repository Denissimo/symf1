<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LogsApi
 *
 * @ORM\Table(name="logs_api", indexes={@ORM\Index(name="result", columns={"result"}), @ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="request_type", columns={"request_type"})})
 * @ORM\Entity
 */
class LogsApi
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip", type="string", length=16, nullable=true, options={"comment"="Вычислить по IP и набить ебало"})
     */
    private $ip;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true, options={"comment"="id юзера"})
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="request", type="text", length=0, nullable=true, options={"comment"="полный текст запроса"})
     */
    private $request;

    /**
     * @var string|null
     *
     * @ORM\Column(name="response", type="text", length=0, nullable=true, options={"comment"="полный текст ответа"})
     */
    private $response;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datetime = 'CURRENT_TIMESTAMP';

    /**
     * @var \ClientSettings
     *
     * @ORM\ManyToOne(targetEntity="ClientSettings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var \LogTypeModel
     *
     * @ORM\ManyToOne(targetEntity="LogTypeModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="request_type", referencedColumnName="id")
     * })
     */
    private $requestType;

    /**
     * @var \LogResultModel
     *
     * @ORM\ManyToOne(targetEntity="LogResultModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="result", referencedColumnName="id")
     * })
     */
    private $result;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return LogsApi
     */
    public function setId(int $id): LogsApi
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     * @return LogsApi
     */
    public function setIp(?string $ip): LogsApi
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     * @return LogsApi
     */
    public function setUserId(?int $userId): LogsApi
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRequest(): ?string
    {
        return $this->request;
    }

    /**
     * @param string|null $request
     * @return LogsApi
     */
    public function setRequest(?string $request): LogsApi
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResponse(): ?string
    {
        return $this->response;
    }

    /**
     * @param string|null $response
     * @return LogsApi
     */
    public function setResponse(?string $response): LogsApi
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }

    /**
     * @param DateTime $datetime
     * @return LogsApi
     */
    public function setDatetime(DateTime $datetime): LogsApi
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return ClientSettings
     */
    public function getClient(): ClientSettings
    {
        return $this->client;
    }

    /**
     * @param ClientSettings $client
     * @return LogsApi
     */
    public function setClient(ClientSettings $client): LogsApi
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return LogTypeModel
     */
    public function getRequestType(): LogTypeModel
    {
        return $this->requestType;
    }

    /**
     * @param LogTypeModel $requestType
     * @return LogsApi
     */
    public function setRequestType(LogTypeModel $requestType): LogsApi
    {
        $this->requestType = $requestType;
        return $this;
    }

    /**
     * @return LogResultModel
     */
    public function getResult(): LogResultModel
    {
        return $this->result;
    }

    /**
     * @param LogResultModel $result
     * @return LogsApi
     */
    public function setResult(LogResultModel $result): LogsApi
    {
        $this->result = $result;
        return $this;
    }


}
