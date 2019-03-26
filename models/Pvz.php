<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Pvz
 *
 * @ORM\Table(name="pvz", indexes={@ORM\Index(name="mxm_id", columns={"mxm_id"}), @ORM\Index(name="mo_punkt_id", columns={"mo_punkt_id"}), @ORM\Index(name="pagent_id", columns={"pagent_id"})})
 * @ORM\Entity
 */
class Pvz extends Model
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
     * @var int|null
     *
     * @ORM\Column(name="mxm_id", type="integer", nullable=true)
     */
    private $mxmId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=256, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=256, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_name", type="string", length=256, nullable=true)
     */
    private $contactName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_number", type="string", length=256, nullable=true)
     */
    private $contactNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_mail", type="string", length=256, nullable=true)
     */
    private $contactMail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dognum", type="string", length=256, nullable=true)
     */
    private $dognum;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dogdate", type="string", length=256, nullable=true)
     */
    private $dogdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pathDesc", type="text", length=0, nullable=true)
     */
    private $pathdesc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="workTime", type="string", length=256, nullable=true)
     */
    private $worktime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="workTime2", type="string", length=256, nullable=true)
     */
    private $worktime2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addrFull", type="string", length=256, nullable=true)
     */
    private $addrfull;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addrStreet", type="string", length=256, nullable=true)
     */
    private $addrstreet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addrHouse", type="string", length=256, nullable=true)
     */
    private $addrhouse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="coords", type="string", length=256, nullable=true)
     */
    private $coords;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deliveryCost", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $deliverycost;

    /**
     * @var string|null
     *
     * @ORM\Column(name="route", type="string", length=256, nullable=true)
     */
    private $route;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mo_punkt_id", type="string", length=256, nullable=true)
     */
    private $moPunktId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pvz_type", type="integer", nullable=true)
     */
    private $pvzType;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pvz_tar", type="integer", nullable=true)
     */
    private $pvzTar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pagent_id", type="integer", nullable=true)
     */
    private $pagentId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="internal", type="integer", nullable=true)
     */
    private $internal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="np", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $np;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tar", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $tar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="weight", type="integer", nullable=true)
     */
    private $weight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true, options={"default"="1"})
     */
    private $status = '1';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="chdate", type="datetime", nullable=true)
     */
    private $chdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="string", length=256, nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment2", type="string", length=256, nullable=true)
     */
    private $comment2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postal_code", type="string", length=256, nullable=true)
     */
    private $postalCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region_with_type", type="string", length=256, nullable=true)
     */
    private $regionWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="area_with_type", type="string", length=256, nullable=true)
     */
    private $areaWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city_with_type", type="string", length=256, nullable=true)
     */
    private $cityWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city_district_with_type", type="string", length=256, nullable=true)
     */
    private $cityDistrictWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="settlement_with_type", type="string", length=256, nullable=true)
     */
    private $settlementWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street_with_type", type="string", length=256, nullable=true)
     */
    private $streetWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="house", type="string", length=256, nullable=true)
     */
    private $house;

    /**
     * @var string|null
     *
     * @ORM\Column(name="block", type="string", length=256, nullable=true)
     */
    private $block;

    /**
     * @var int|null
     *
     * @ORM\Column(name="parent_company", type="integer", nullable=true)
     */
    private $parentCompany;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ek", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Эквайринг"})
     */
    private $ek;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Pvz
     */
    public function setId(int $id): Pvz
    {
        $this->id = $id;
        return $this;
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
     * @return Pvz
     */
    public function setOldId(?int $old_id): Pvz
    {
        $this->old_id = $old_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMxmId(): ?int
    {
        return $this->mxmId;
    }

    /**
     * @param int|null $mxmId
     * @return Pvz
     */
    public function setMxmId(?int $mxmId): Pvz
    {
        $this->mxmId = $mxmId;
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
     * @return Pvz
     */
    public function setName(?string $name): Pvz
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return Pvz
     */
    public function setCode(?string $code): Pvz
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    /**
     * @param string|null $contactName
     * @return Pvz
     */
    public function setContactName(?string $contactName): Pvz
    {
        $this->contactName = $contactName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    /**
     * @param string|null $contactNumber
     * @return Pvz
     */
    public function setContactNumber(?string $contactNumber): Pvz
    {
        $this->contactNumber = $contactNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactMail(): ?string
    {
        return $this->contactMail;
    }

    /**
     * @param string|null $contactMail
     * @return Pvz
     */
    public function setContactMail(?string $contactMail): Pvz
    {
        $this->contactMail = $contactMail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDognum(): ?string
    {
        return $this->dognum;
    }

    /**
     * @param string|null $dognum
     * @return Pvz
     */
    public function setDognum(?string $dognum): Pvz
    {
        $this->dognum = $dognum;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDogdate(): ?string
    {
        return $this->dogdate;
    }

    /**
     * @param string|null $dogdate
     * @return Pvz
     */
    public function setDogdate(?string $dogdate): Pvz
    {
        $this->dogdate = $dogdate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPathdesc(): ?string
    {
        return $this->pathdesc;
    }

    /**
     * @param string|null $pathdesc
     * @return Pvz
     */
    public function setPathdesc(?string $pathdesc): Pvz
    {
        $this->pathdesc = $pathdesc;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWorktime(): ?string
    {
        return $this->worktime;
    }

    /**
     * @param string|null $worktime
     * @return Pvz
     */
    public function setWorktime(?string $worktime): Pvz
    {
        $this->worktime = $worktime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWorktime2(): ?string
    {
        return $this->worktime2;
    }

    /**
     * @param string|null $worktime2
     * @return Pvz
     */
    public function setWorktime2(?string $worktime2): Pvz
    {
        $this->worktime2 = $worktime2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddrfull(): ?string
    {
        return $this->addrfull;
    }

    /**
     * @param string|null $addrfull
     * @return Pvz
     */
    public function setAddrfull(?string $addrfull): Pvz
    {
        $this->addrfull = $addrfull;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddrstreet(): ?string
    {
        return $this->addrstreet;
    }

    /**
     * @param string|null $addrstreet
     * @return Pvz
     */
    public function setAddrstreet(?string $addrstreet): Pvz
    {
        $this->addrstreet = $addrstreet;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddrhouse(): ?string
    {
        return $this->addrhouse;
    }

    /**
     * @param string|null $addrhouse
     * @return Pvz
     */
    public function setAddrhouse(?string $addrhouse): Pvz
    {
        $this->addrhouse = $addrhouse;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCoords(): ?string
    {
        return $this->coords;
    }

    /**
     * @param string|null $coords
     * @return Pvz
     */
    public function setCoords(?string $coords): Pvz
    {
        $this->coords = $coords;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliverycost(): ?string
    {
        return $this->deliverycost;
    }

    /**
     * @param string|null $deliverycost
     * @return Pvz
     */
    public function setDeliverycost(?string $deliverycost): Pvz
    {
        $this->deliverycost = $deliverycost;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @param string|null $route
     * @return Pvz
     */
    public function setRoute(?string $route): Pvz
    {
        $this->route = $route;
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
     * @return Pvz
     */
    public function setMoPunktId(?string $moPunktId): Pvz
    {
        $this->moPunktId = $moPunktId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPvzType(): ?int
    {
        return $this->pvzType;
    }

    /**
     * @param int|null $pvzType
     * @return Pvz
     */
    public function setPvzType(?int $pvzType): Pvz
    {
        $this->pvzType = $pvzType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPvzTar(): ?int
    {
        return $this->pvzTar;
    }

    /**
     * @param int|null $pvzTar
     * @return Pvz
     */
    public function setPvzTar(?int $pvzTar): Pvz
    {
        $this->pvzTar = $pvzTar;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPagentId(): ?int
    {
        return $this->pagentId;
    }

    /**
     * @param int|null $pagentId
     * @return Pvz
     */
    public function setPagentId(?int $pagentId): Pvz
    {
        $this->pagentId = $pagentId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getInternal(): ?int
    {
        return $this->internal;
    }

    /**
     * @param int|null $internal
     * @return Pvz
     */
    public function setInternal(?int $internal): Pvz
    {
        $this->internal = $internal;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNp(): ?string
    {
        return $this->np;
    }

    /**
     * @param string|null $np
     * @return Pvz
     */
    public function setNp(?string $np): Pvz
    {
        $this->np = $np;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTar(): ?string
    {
        return $this->tar;
    }

    /**
     * @param string|null $tar
     * @return Pvz
     */
    public function setTar(?string $tar): Pvz
    {
        $this->tar = $tar;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @param int|null $weight
     * @return Pvz
     */
    public function setWeight(?int $weight): Pvz
    {
        $this->weight = $weight;
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
     * @return Pvz
     */
    public function setStatus(?int $status): Pvz
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getChdate(): ?DateTime
    {
        return $this->chdate;
    }

    /**
     * @param DateTime|null $chdate
     * @return Pvz
     */
    public function setChdate(?DateTime $chdate): Pvz
    {
        $this->chdate = $chdate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return Pvz
     */
    public function setComment(?string $comment): Pvz
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment2(): ?string
    {
        return $this->comment2;
    }

    /**
     * @param string|null $comment2
     * @return Pvz
     */
    public function setComment2(?string $comment2): Pvz
    {
        $this->comment2 = $comment2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     * @return Pvz
     */
    public function setPostalCode(?string $postalCode): Pvz
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegionWithType(): ?string
    {
        return $this->regionWithType;
    }

    /**
     * @param string|null $regionWithType
     * @return Pvz
     */
    public function setRegionWithType(?string $regionWithType): Pvz
    {
        $this->regionWithType = $regionWithType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAreaWithType(): ?string
    {
        return $this->areaWithType;
    }

    /**
     * @param string|null $areaWithType
     * @return Pvz
     */
    public function setAreaWithType(?string $areaWithType): Pvz
    {
        $this->areaWithType = $areaWithType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCityWithType(): ?string
    {
        return $this->cityWithType;
    }

    /**
     * @param string|null $cityWithType
     * @return Pvz
     */
    public function setCityWithType(?string $cityWithType): Pvz
    {
        $this->cityWithType = $cityWithType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCityDistrictWithType(): ?string
    {
        return $this->cityDistrictWithType;
    }

    /**
     * @param string|null $cityDistrictWithType
     * @return Pvz
     */
    public function setCityDistrictWithType(?string $cityDistrictWithType): Pvz
    {
        $this->cityDistrictWithType = $cityDistrictWithType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSettlementWithType(): ?string
    {
        return $this->settlementWithType;
    }

    /**
     * @param string|null $settlementWithType
     * @return Pvz
     */
    public function setSettlementWithType(?string $settlementWithType): Pvz
    {
        $this->settlementWithType = $settlementWithType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreetWithType(): ?string
    {
        return $this->streetWithType;
    }

    /**
     * @param string|null $streetWithType
     * @return Pvz
     */
    public function setStreetWithType(?string $streetWithType): Pvz
    {
        $this->streetWithType = $streetWithType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouse(): ?string
    {
        return $this->house;
    }

    /**
     * @param string|null $house
     * @return Pvz
     */
    public function setHouse(?string $house): Pvz
    {
        $this->house = $house;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBlock(): ?string
    {
        return $this->block;
    }

    /**
     * @param string|null $block
     * @return Pvz
     */
    public function setBlock(?string $block): Pvz
    {
        $this->block = $block;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getParentCompany(): ?int
    {
        return $this->parentCompany;
    }

    /**
     * @param int|null $parentCompany
     * @return Pvz
     */
    public function setParentCompany(?int $parentCompany): Pvz
    {
        $this->parentCompany = $parentCompany;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEk(): ?string
    {
        return $this->ek;
    }

    /**
     * @param string|null $ek
     * @return Pvz
     */
    public function setEk(?string $ek): Pvz
    {
        $this->ek = $ek;
        return $this;
    }

}
