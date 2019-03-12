<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersHistory
 *
 * @ORM\Table(name="orders_history", indexes={@ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="oid", columns={"oid"}), @ORM\Index(name="type", columns={"type"})})
 * @ORM\Entity
 */
class OrdersHistory
{

    const API_OID = 1
    ;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true, options={"comment"="автор - наш юзер"})
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="parameter", type="string", length=255, nullable=true, options={"comment"="название параметра"})
     */
    private $parameter;

    /**
     * @var string|null
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true, options={"comment"="новое значеие"})
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP","comment"="Дата/Время"})
     */
    private $datetime = 'CURRENT_TIMESTAMP';

    /**
     * @var \Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="oid", referencedColumnName="id")
     * })
     */
    private $oid;

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
     * @var \OrdersHistoryTypesModel
     *
     * @ORM\ManyToOne(targetEntity="OrdersHistoryTypesModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersHistory
     */
    public function setId(int $id): OrdersHistory
    {
        $this->id = $id;
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
     * @return OrdersHistory
     */
    public function setUserId(?int $userId): OrdersHistory
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParameter(): ?string
    {
        return $this->parameter;
    }

    /**
     * @param string|null $parameter
     * @return OrdersHistory
     */
    public function setParameter(?string $parameter): OrdersHistory
    {
        $this->parameter = $parameter;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return OrdersHistory
     */
    public function setValue(?string $value): OrdersHistory
    {
        $this->value = $value;
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
     * @return OrdersHistory
     */
    public function setDatetime(DateTime $datetime): OrdersHistory
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return Orders
     */
    public function getOid(): Orders
    {
        return $this->oid;
    }

    /**
     * @param Orders $oid
     * @return OrdersHistory
     */
    public function setOid(Orders $oid): OrdersHistory
    {
        $this->oid = $oid;
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
     * @return OrdersHistory
     */
    public function setClient(ClientSettings $client): OrdersHistory
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return OrdersHistoryTypesModel
     */
    public function getType(): OrdersHistoryTypesModel
    {
        return $this->type;
    }

    /**
     * @param OrdersHistoryTypesModel $type
     * @return OrdersHistory
     */
    public function setType(OrdersHistoryTypesModel $type): OrdersHistory
    {
        $this->type = $type;
        return $this;
    }

}
