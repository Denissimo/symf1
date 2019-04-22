<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PlacesBarcodes
 *
 * @ORM\Table(name="places_barcodes", indexes={@ORM\Index(name="shk", columns={"shk"}), @ORM\Index(name="pb_status", columns={"status"}), @ORM\Index(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class PlacesBarcodes
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
     * @var int|null
     *
     * @ORM\Column(name="place", type="integer", nullable=true)
     */
    private $place;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shk", type="string", length=255, nullable=true)
     */
    private $shk;

    /**
     * @var float|null
     *
     * @ORM\Column(name="weight", type="float", precision=9, scale=2, nullable=true)
     */
    private $weight;

    /**
     * @var string|null
     *
     * @ORM\Column(name="goods", type="text", length=0, nullable=true)
     */
    private $goods;

    /**
     * @var int|null
     *
     * @ORM\Column(name="reserved", type="integer", nullable=true)
     */
    private $reserved;

    /**
     * @var int|null
     *
     * @ORM\Column(name="first_sklad_scan", type="integer", nullable=true)
     */
    private $firstSkladScan = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_cancle", type="integer", nullable=true, options={"comment"="Если 1 то отменен"})
     */
    private $isCancle = '0';

    /**
     * @var \Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

    /**
     * @var \PlacesBarcodesStatusModel
     *
     * @ORM\ManyToOne(targetEntity="PlacesBarcodesStatusModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PlacesBarcodes
     */
    public function setId(int $id): PlacesBarcodes
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPlace(): ?int
    {
        return $this->place;
    }

    /**
     * @param int|null $place
     * @return PlacesBarcodes
     */
    public function setPlace(?int $place): PlacesBarcodes
    {
        $this->place = $place;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShk(): ?string
    {
        return $this->shk;
    }

    /**
     * @param string|null $shk
     * @return PlacesBarcodes
     */
    public function setShk(?string $shk): PlacesBarcodes
    {
        $this->shk = $shk;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     * @param float|null $weight
     * @return PlacesBarcodes
     */
    public function setWeight(?float $weight): PlacesBarcodes
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGoods(): ?string
    {
        return $this->goods;
    }

    /**
     * @param string|null $goods
     * @return PlacesBarcodes
     */
    public function setGoods(?string $goods): PlacesBarcodes
    {
        $this->goods = $goods;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getReserved(): ?int
    {
        return $this->reserved;
    }

    /**
     * @param int|null $reserved
     * @return PlacesBarcodes
     */
    public function setReserved(?int $reserved): PlacesBarcodes
    {
        $this->reserved = $reserved;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFirstSkladScan(): ?int
    {
        return $this->firstSkladScan;
    }

    /**
     * @param int|null $firstSkladScan
     * @return PlacesBarcodes
     */
    public function setFirstSkladScan(?int $firstSkladScan): PlacesBarcodes
    {
        $this->firstSkladScan = $firstSkladScan;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIsCancle(): ?int
    {
        return $this->isCancle;
    }

    /**
     * @param int|null $isCancle
     * @return PlacesBarcodes
     */
    public function setIsCancle(?int $isCancle): PlacesBarcodes
    {
        $this->isCancle = $isCancle;
        return $this;
    }

    /**
     * @return Orders
     */
    public function getOrder(): Orders
    {
        return $this->order;
    }

    /**
     * @param Orders $order
     * @return PlacesBarcodes
     */
    public function setOrder(Orders $order): PlacesBarcodes
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return PlacesBarcodesStatusModel
     */
    public function getStatus(): PlacesBarcodesStatusModel
    {
        return $this->status;
    }

    /**
     * @param PlacesBarcodesStatusModel $status
     * @return PlacesBarcodes
     */
    public function setStatus(PlacesBarcodesStatusModel $status): PlacesBarcodes
    {
        $this->status = $status;
        return $this;
    }

}
