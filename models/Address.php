<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address", indexes={@ORM\Index(name="address_type", columns={"type"})})
 * @ORM\Entity
 */
class Address
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
     * @ORM\Column(name="pvz_id", type="string", length=255, nullable=true, options={"comment"="Номер склада / null если заказчик"})
     */
    private $pvzId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="post_index", type="string", length=6, nullable=true, options={"comment"="почтовый индекс"})
     */
    private $postIndex;

    /**
     * @var string|null
     *
     * @ORM\Column(name="post_addr", type="string", length=256, nullable=true, options={"comment"="Почтовый адрес"})
     */
    private $postAddr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reg_city", type="string", length=256, nullable=true)
     */
    private $regCity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reg_fulladdr", type="string", length=256, nullable=true, options={"comment"="полный адрес"})
     */
    private $regFulladdr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=256, nullable=true, options={"comment"="Город доставки"})
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mo_punkt_id", type="string", length=256, nullable=true, options={"comment"="Кладр города доставки"})
     */
    private $moPunktId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="mo_mkad", type="integer", nullable=true, options={"comment"="dadata удаленность от мкад"})
     */
    private $moMkad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="zone_id", type="integer", nullable=true, options={"comment"="Зона доставки"})
     */
    private $zoneId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street", type="string", length=256, nullable=true, options={"comment"="Улица доставки"})
     */
    private $street;

    /**
     * @var string|null
     *
     * @ORM\Column(name="building", type="string", length=256, nullable=true, options={"comment"="Дом доставки"})
     */
    private $building;

    /**
     * @var string|null
     *
     * @ORM\Column(name="corpus", type="string", length=256, nullable=true, options={"comment"="Корпус"})
     */
    private $corpus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="office", type="integer", nullable=true, options={"comment"="Офис-квартира"})
     */
    private $office;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domofon", type="string", length=16, nullable=true, options={"comment"="Домофон"})
     */
    private $domofon;

    /**
     * @var int|null
     *
     * @ORM\Column(name="floor", type="integer", nullable=true, options={"comment"="Этаж"})
     */
    private $floor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="decimal", precision=8, scale=6, nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude", type="decimal", precision=8, scale=6, nullable=true)
     */
    private $longitude;

    /**
     * @var \AddressTypesModel
     *
     * @ORM\ManyToOne(targetEntity="AddressTypesModel")
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
     * @return Address
     */
    public function setId(int $id): Address
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPvzId(): ?string
    {
        return $this->pvzId;
    }

    /**
     * @param string|null $pvzId
     * @return Address
     */
    public function setPvzId(?string $pvzId): Address
    {
        $this->pvzId = $pvzId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostIndex(): ?string
    {
        return $this->postIndex;
    }

    /**
     * @param string|null $postIndex
     * @return Address
     */
    public function setPostIndex(?string $postIndex): Address
    {
        $this->postIndex = $postIndex;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostAddr(): ?string
    {
        return $this->postAddr;
    }

    /**
     * @param string|null $postAddr
     * @return Address
     */
    public function setPostAddr(?string $postAddr): Address
    {
        $this->postAddr = $postAddr;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegCity(): ?string
    {
        return $this->regCity;
    }

    /**
     * @param string|null $regCity
     * @return Address
     */
    public function setRegCity(?string $regCity): Address
    {
        $this->regCity = $regCity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegFulladdr(): ?string
    {
        return $this->regFulladdr;
    }

    /**
     * @param string|null $regFulladdr
     * @return Address
     */
    public function setRegFulladdr(?string $regFulladdr): Address
    {
        $this->regFulladdr = $regFulladdr;
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
     * @return Address
     */
    public function setCity(?string $city): Address
    {
        $this->city = $city;
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
     * @return Address
     */
    public function setMoPunktId(?string $moPunktId): Address
    {
        $this->moPunktId = $moPunktId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMoMkad(): ?int
    {
        return $this->moMkad;
    }

    /**
     * @param int|null $moMkad
     * @return Address
     */
    public function setMoMkad(?int $moMkad): Address
    {
        $this->moMkad = $moMkad;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getZoneId(): ?int
    {
        return $this->zoneId;
    }

    /**
     * @param int|null $zoneId
     * @return Address
     */
    public function setZoneId(?int $zoneId): Address
    {
        $this->zoneId = $zoneId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     * @return Address
     */
    public function setStreet(?string $street): Address
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuilding(): ?string
    {
        return $this->building;
    }

    /**
     * @param string|null $building
     * @return Address
     */
    public function setBuilding(?string $building): Address
    {
        $this->building = $building;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCorpus(): ?string
    {
        return $this->corpus;
    }

    /**
     * @param string|null $corpus
     * @return Address
     */
    public function setCorpus(?string $corpus): Address
    {
        $this->corpus = $corpus;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOffice(): ?int
    {
        return $this->office;
    }

    /**
     * @param int|null $office
     * @return Address
     */
    public function setOffice(?int $office): Address
    {
        $this->office = $office;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDomofon(): ?string
    {
        return $this->domofon;
    }

    /**
     * @param string|null $domofon
     * @return Address
     */
    public function setDomofon(?string $domofon): Address
    {
        $this->domofon = $domofon;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFloor(): ?int
    {
        return $this->floor;
    }

    /**
     * @param int|null $floor
     * @return Address
     */
    public function setFloor(?int $floor): Address
    {
        $this->floor = $floor;
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
     * @return Address
     */
    public function setLatitude(?string $latitude): Address
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string|null $longitude
     * @return Address
     */
    public function setLongitude(?string $longitude): Address
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return AddressTypesModel
     */
    public function getType(): AddressTypesModel
    {
        return $this->type;
    }

    /**
     * @param AddressTypesModel $type
     * @return Address
     */
    public function setType(AddressTypesModel $type): Address
    {
        $this->type = $type;
        return $this;
    }

}
