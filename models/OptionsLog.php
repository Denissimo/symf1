<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OptionsLog
 *
 * @ORM\Table(name="options_log")
 * @ORM\Entity
 */
class OptionsLog
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="upd", type="datetime", nullable=true)
     */
    private $upd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="order_id", type="integer", nullable=true)
     */
    private $orderId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="use_order_id", type="integer", nullable=true)
     */
    private $useOrderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sqt", type="text", length=16777215, nullable=true)
     */
    private $sqt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datetime;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OptionsLog
     */
    public function setId(int $id): OptionsLog
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpd(): ?DateTime
    {
        return $this->upd;
    }

    /**
     * @param DateTime|null $update
     * @return OptionsLog
     */
    public function setUpd(?DateTime $update): OptionsLog
    {
        $this->upd = $update;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    /**
     * @param int|null $orderId
     * @return OptionsLog
     */
    public function setOrderId(?int $orderId): OptionsLog
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUseOrderId(): ?int
    {
        return $this->useOrderId;
    }

    /**
     * @param int|null $useOrderId
     * @return OptionsLog
     */
    public function setUseOrderId(?int $useOrderId): OptionsLog
    {
        $this->useOrderId = $useOrderId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSqt(): ?string
    {
        return $this->sqt;
    }

    /**
     * @param string|null $sql
     * @return OptionsLog
     */
    public function setSqt(?string $sql): OptionsLog
    {
        $this->sqt = $sql;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDatetime(): ?DateTime
    {
        return $this->datetime;
    }

    /**
     * @param DateTime|null $datetime
     * @return OptionsLog
     */
    public function setDatetime(?DateTime $datetime): OptionsLog
    {
        $this->datetime = $datetime;
        return $this;
    }


}
