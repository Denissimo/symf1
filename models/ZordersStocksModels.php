<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersStocksModels
 *
 * @ORM\Table(name="zorders_stocks_models", indexes={@ORM\Index(name="mo_punkt_id", columns={"mo_punkt_id"}), @ORM\Index(name="client_id", columns={"client_id"})})
 * @ORM\Entity
 */
class ZordersStocksModels extends Model
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
     * @ORM\Column(name="old_id", type="integer", nullable=true)
     */
    private $old_id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="text", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addr", type="text", length=255, nullable=true)
     */
    private $addr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="text", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longtitude", type="string", length=50, nullable=true)
     */
    private $longtitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="string", length=50, nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comments", type="text", length=255, nullable=true)
     */
    private $comments;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cont_lico", type="text", length=255, nullable=true)
     */
    private $contLico;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cont_tel", type="text", length=255, nullable=true)
     */
    private $contTel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="time", type="text", length=255, nullable=true)
     */
    private $time;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mo_punkt_id", type="string", length=256, nullable=true)
     */
    private $moPunktId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="inner_n", type="string", length=256, nullable=true)
     */
    private $innerN;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getOldId(): ?int
    {
        return $this->old_id;
    }

    /**
     * @param int|null $old_id
     * @return ZordersStocksModels
     */
    public function setOldId(?int $old_id): ZordersStocksModels
    {
        $this->old_id = $old_id;
        return $this;
    }

    /**
     * @param int $id
     * @return ZordersStocksModels
     */
    public function setId(int $id): ZordersStocksModels
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return ZordersStocksModels
     */
    public function setName(?string $name): ZordersStocksModels
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddr(): ?string
    {
        return $this->addr;
    }

    /**
     * @param string|null $addr
     * @return ZordersStocksModels
     */
    public function setAddr(?string $addr): ZordersStocksModels
    {
        $this->addr = $addr;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return ZordersStocksModels
     */
    public function setCity(?string $city): ZordersStocksModels
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongtitude(): ?string
    {
        return $this->longtitude;
    }

    /**
     * @param string|null $longtitude
     * @return ZordersStocksModels
     */
    public function setLongtitude(?string $longtitude): ZordersStocksModels
    {
        $this->longtitude = $longtitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string|null $latitude
     * @return ZordersStocksModels
     */
    public function setLatitude(?string $latitude): ZordersStocksModels
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    /**
     * @param string|null $comments
     * @return ZordersStocksModels
     */
    public function setComments(?string $comments): ZordersStocksModels
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContLico(): ?string
    {
        return $this->contLico;
    }

    /**
     * @param string|null $contLico
     * @return ZordersStocksModels
     */
    public function setContLico(?string $contLico): ZordersStocksModels
    {
        $this->contLico = $contLico;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContTel(): ?string
    {
        return $this->contTel;
    }

    /**
     * @param string|null $contTel
     * @return ZordersStocksModels
     */
    public function setContTel(?string $contTel): ZordersStocksModels
    {
        $this->contTel = $contTel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param string|null $time
     * @return ZordersStocksModels
     */
    public function setTime(?string $time): ZordersStocksModels
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMoPunktId(): ?string
    {
        return $this->moPunktId;
    }

    /**
     * @param string|null $moPunktId
     * @return ZordersStocksModels
     */
    public function setMoPunktId(?string $moPunktId): ZordersStocksModels
    {
        $this->moPunktId = $moPunktId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInnerN(): ?string
    {
        return $this->innerN;
    }

    /**
     * @param string|null $innerN
     * @return ZordersStocksModels
     */
    public function setInnerN(?string $innerN): ZordersStocksModels
    {
        $this->innerN = $innerN;
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
     * @return ZordersStocksModels
     */
    public function setClient(ClientSettings $client): ZordersStocksModels
    {
        $this->client = $client;
        return $this;
    }
}
