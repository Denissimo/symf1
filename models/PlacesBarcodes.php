<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PlacesBarcodes
 *
 * @ORM\Table(name="places_barcodes", indexes={@ORM\Index(name="order_id", columns={"oid"}), @ORM\Index(name="barcode", columns={"barcode"})})
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
     * @ORM\Column(name="barcode", type="string", length=255, nullable=true)
     */
    private $barcode;

    /**
     * @var float|null
     *
     * @ORM\Column(name="weight", type="float", precision=9, scale=2, nullable=true)
     */
    private $weight;

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
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

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
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     * @return PlacesBarcodes
     */
    public function setBarcode(?string $barcode): PlacesBarcodes
    {
        $this->barcode = $barcode;
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
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return PlacesBarcodes
     */
    public function setStatus(?int $status): PlacesBarcodes
    {
        $this->status = $status;
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
     * @return PlacesBarcodes
     */
    public function setOid(Orders $oid): PlacesBarcodes
    {
        $this->oid = $oid;
        return $this;
    }

}
