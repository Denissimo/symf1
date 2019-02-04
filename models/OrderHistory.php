<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrderHistory
 *
 * @ORM\Table(name="order_history", indexes={@ORM\Index(name="old_id_logs", columns={"description"}), @ORM\Index(name="IDX_logs_orders_what", columns={"what"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class OrderHistory
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
     * @ORM\Column(name="order_id", type="string", length=255, nullable=true, options={"comment"="Номер заказа наш"})
     */
    private $orderId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="what", type="integer", nullable=true)
     */
    private $what;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_id", type="string", length=255, nullable=true, options={"comment"="id пользователя - Клиента"})
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true, options={"comment"="Старый id - заказа"})
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="old_value", type="text", length=0, nullable=true, options={"comment"="Описание"})
     */
    private $oldValue;

    /**
     * @var json|null
     *
     * @ORM\Column(name="json", type="json", nullable=true, options={"comment"="Передача json"})
     */
    private $json;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status_logs", type="string", length=255, nullable=true, options={"comment"="Статусы"})
     */
    private $statusLogs;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="time", type="time", nullable=true, options={"comment"="Дата создания"})
     */
    private $time;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrderHistory
     */
    public function setId(int $id): OrderHistory
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @param string|null $orderId
     * @return OrderHistory
     */
    public function setOrderId(?string $orderId): OrderHistory
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWhat(): ?int
    {
        return $this->what;
    }

    /**
     * @param int|null $what
     * @return OrderHistory
     */
    public function setWhat(?int $what): OrderHistory
    {
        $this->what = $what;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->userId;
    }

    /**
     * @param string|null $userId
     * @return OrderHistory
     */
    public function setUserId(?string $userId): OrderHistory
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return OrderHistory
     */
    public function setDescription(?string $description): OrderHistory
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOldValue(): ?string
    {
        return $this->oldValue;
    }

    /**
     * @param string|null $oldValue
     * @return OrderHistory
     */
    public function setOldValue(?string $oldValue): OrderHistory
    {
        $this->oldValue = $oldValue;
        return $this;
    }

    /**
     * @return json|null
     */
    public function getJson(): ?json
    {
        return $this->json;
    }

    /**
     * @param json|null $json
     * @return OrderHistory
     */
    public function setJson(?json $json): OrderHistory
    {
        $this->json = $json;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatusLogs(): ?string
    {
        return $this->statusLogs;
    }

    /**
     * @param string|null $statusLogs
     * @return OrderHistory
     */
    public function setStatusLogs(?string $statusLogs): OrderHistory
    {
        $this->statusLogs = $statusLogs;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime|null $date
     * @return OrderHistory
     */
    public function setDate(?DateTime $date): OrderHistory
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getTime(): ?DateTime
    {
        return $this->time;
    }

    /**
     * @param DateTime|null $time
     * @return OrderHistory
     */
    public function setTime(?DateTime $time): OrderHistory
    {
        $this->time = $time;
        return $this;
    }

}
