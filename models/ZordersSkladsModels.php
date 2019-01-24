<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersSkladsModels
 *
 * @ORM\Table(name="zorders_sklads_models", indexes={@ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="mo_punkt_id", columns={"mo_punkt_id"})})
 * @ORM\Entity
 */
class ZordersSkladsModels
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
     * @var int|null
     *
     * @ORM\Column(name="client_id", type="integer", nullable=true)
     */
    private $clientId;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ZordersSkladsModels
     */
    public function setId(int $id): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setName(?string $name): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setAddr(?string $addr): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setCity(?string $city): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setLongtitude(?string $longtitude): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setLatitude(?string $latitude): ZordersSkladsModels
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    /**
     * @param int|null $clientId
     * @return ZordersSkladsModels
     */
    public function setClientId(?int $clientId): ZordersSkladsModels
    {
        $this->clientId = $clientId;
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
     * @return ZordersSkladsModels
     */
    public function setComments(?string $comments): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setContLico(?string $contLico): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setContTel(?string $contTel): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setTime(?string $time): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setMoPunktId(?string $moPunktId): ZordersSkladsModels
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
     * @return ZordersSkladsModels
     */
    public function setInnerN(?string $innerN): ZordersSkladsModels
    {
        $this->innerN = $innerN;
        return $this;
    }


}
