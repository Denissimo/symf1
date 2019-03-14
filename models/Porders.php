<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Porders
 *
 * @ORM\Table(name="porders", indexes={@ORM\Index(name="order_id", columns={"order_id"}), @ORM\Index(name="bill_id", columns={"bill_id"}), @ORM\Index(name="podstatus_id", columns={"podstatus_id"})})
 * @ORM\Entity
 */
class Porders
{
    const
        ORDER_ID = 'orderId'
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
     * @var string|null
     *
     * @ORM\Column(name="order_id", type="string", length=256, nullable=true)
     */
    private $orderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="atar", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $atar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="anp", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $anp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aus", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $aus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bill_id", type="string", length=256, nullable=true)
     */
    private $billId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="enddate", type="date", nullable=true)
     */
    private $enddate;

    /**
     * @var \PordersPodstatusModel
     *
     * @ORM\ManyToOne(targetEntity="PordersPodstatusModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="podstatus_id", referencedColumnName="id")
     * })
     */
    private $podstatus;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Porders
     */
    public function setId(int $id): Porders
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
     * @return Porders
     */
    public function setOrderId(?string $orderId): Porders
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAtar(): ?string
    {
        return $this->atar;
    }

    /**
     * @param string|null $atar
     * @return Porders
     */
    public function setAtar(?string $atar): Porders
    {
        $this->atar = $atar;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnp(): ?string
    {
        return $this->anp;
    }

    /**
     * @param string|null $anp
     * @return Porders
     */
    public function setAnp(?string $anp): Porders
    {
        $this->anp = $anp;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAus(): ?string
    {
        return $this->aus;
    }

    /**
     * @param string|null $aus
     * @return Porders
     */
    public function setAus(?string $aus): Porders
    {
        $this->aus = $aus;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBillId(): ?string
    {
        return $this->billId;
    }

    /**
     * @param string|null $billId
     * @return Porders
     */
    public function setBillId(?string $billId): Porders
    {
        $this->billId = $billId;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getEnddate(): ?DateTime
    {
        return $this->enddate;
    }

    /**
     * @param DateTime|null $enddate
     * @return Porders
     */
    public function setEnddate(?DateTime $enddate): Porders
    {
        $this->enddate = $enddate;
        return $this;
    }

    /**
     * @return PordersPodstatusModel
     */
    public function getPodstatus(): PordersPodstatusModel
    {
        return $this->podstatus;
    }

    /**
     * @param PordersPodstatusModel $podstatus
     * @return Porders
     */
    public function setPodstatus(PordersPodstatusModel $podstatus): Porders
    {
        $this->podstatus = $podstatus;
        return $this;
    }

}
