<?php


use Doctrine\ORM\Mapping as ORM;

/**
 * Zorders
 *
 * @ORM\Table(name="zorders", indexes={@ORM\Index(name="mo_kladr_id", columns={"mo_kladr_id"}), @ORM\Index(name="courier_id", columns={"courier_id"}), @ORM\Index(name="bill_id", columns={"bill_id"}), @ORM\Index(name="stock_our", columns={"stock_our"}), @ORM\Index(name="zone_id", columns={"zone_id"}), @ORM\Index(name="type", columns={"type"}), @ORM\Index(name="status", columns={"status"}), @ORM\Index(name="date", columns={"date"}), @ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="stocks", columns={"stock_id"}), @ORM\Index(name="zpvz_id", columns={"zpvz_id"}), @ORM\Index(name="vakt_part_status", columns={"vakt_part_status"})})
 * @ORM\Entity
 */
class Zorders extends Model
{
    const
        CLIENT = 'client',
        INNER = 'inner',
        OLDID = 'oldId',
        ID = 'id';

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
     * @ORM\Column(name="old_id", type="integer", nullable=true, options={"comment"="Старый id из древней БД"})
     */
    private $oldId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var int|null
     *
     * @ORM\Column(name="client_id", type="integer", nullable=true)
     */
    private $clientId;


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
     * @var int|null
     *
     * @ORM\Column(name="courier_id", type="integer", nullable=true)
     */
    private $courierId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="inner_cli", type="string", length=256, nullable=true)
     */
    private $innerCli;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mo_kladr_id", type="string", length=256, nullable=true)
     */
    private $moKladrId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="zone_id", type="integer", nullable=true)
     */
    private $zoneId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="iner", type="string", length=256, nullable=true)
     */
    private $inner;

    /**
     * @var string|null
     *
     * @ORM\Column(name="time1", type="text", length=255, nullable=true)
     */
    private $time1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="time2", type="text", length=255, nullable=true)
     */
    private $time2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zcomments", type="string", length=1000, nullable=true)
     */
    private $zcomments;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_pay", type="integer", nullable=true)
     */
    private $isPay;

    /**
     * @var int|null
     *
     * @ORM\Column(name="zpvz_id", type="integer", nullable=true)
     */
    private $zpvzId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zprice", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $zprice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bill_id", type="string", length=256, nullable=true)
     */
    private $billId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="weight", type="string", length=256, nullable=true)
     */
    private $weight;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cap", type="string", length=256, nullable=true)
     */
    private $cap;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cr_cost", type="string", length=256, nullable=true)
     */
    private $crCost;

    /**
     * @var int|null
     *
     * @ORM\Column(name="car_type", type="integer", nullable=true, options={"default"="4","comment"="1- пеший 2- легковое авто 3- каблук 4- фургон"})
     */
    private $carType = '4';

    /**
     * @var int|null
     *
     * @ORM\Column(name="perenos", type="integer", nullable=true)
     */
    private $perenos;

    /**
     * @var int|null
     *
     * @ORM\Column(name="perenos_mark", type="integer", nullable=true)
     */
    private $perenosMark;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="change_date", type="datetime", nullable=true)
     */
    private $changeDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="vozvratmark", type="integer", nullable=true)
     */
    private $vozvratmark;

    /**
     * @var int|null
     *
     * @ORM\Column(name="places_count", type="integer", nullable=true)
     */
    private $placesCount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="vakt_part", type="string", length=255, nullable=true)
     */
    private $vaktPart;

    /**
     * @var \ZordersStatusModel
     *
     * @ORM\ManyToOne(targetEntity="ZordersStatusModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var \ZordersStocksOurModel
     *
     * @ORM\ManyToOne(targetEntity="ZordersStocksOurModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="stock_our", referencedColumnName="id")
     * })
     */
    private $stockOur;

    /**
     * @var \ZordersStocksModels
     *
     * @ORM\ManyToOne(targetEntity="ZordersStocksModels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="stock_id", referencedColumnName="id")
     * })
     */
    private $stock;

    /**
     * @var \ZordersTypesModel
     *
     * @ORM\ManyToOne(targetEntity="ZordersTypesModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var \ZordersVaktPartStatusModel
     *
     * @ORM\ManyToOne(targetEntity="ZordersVaktPartStatusModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vakt_part_status", referencedColumnName="id")
     * })
     */
    private $vaktPartStatus;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Zorders
     */
    public function setId(int $id): Zorders
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOldId(): ?int
    {
        return $this->oldId;
    }

    /**
     * @param int|null $oldId
     * @return Zorders
     */
    public function setOldId(?int $oldId): Zorders
    {
        $this->oldId = $oldId;
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
     * @return Zorders
     */
    public function setDate(?DateTime $date): Zorders
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param ClientSettings $client
     * @return Zorders
     */
    public function setClient(ClientSettings $client): Zorders
    {
        $this->client = $client;
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
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    /**
     * @param int|null $clientId
     * @return Zorders
     */
    public function setClientId(?int $clientId): Zorders
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCourierId(): ?int
    {
        return $this->courierId;
    }

    /**
     * @param int|null $courierId
     * @return Zorders
     */
    public function setCourierId(?int $courierId): Zorders
    {
        $this->courierId = $courierId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInnerCli(): ?string
    {
        return $this->innerCli;
    }

    /**
     * @param string|null $innerCli
     * @return Zorders
     */
    public function setInnerCli(?string $innerCli): Zorders
    {
        $this->innerCli = $innerCli;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMoKladrId(): ?string
    {
        return $this->moKladrId;
    }

    /**
     * @param string|null $moKladrId
     * @return Zorders
     */
    public function setMoKladrId(?string $moKladrId): Zorders
    {
        $this->moKladrId = $moKladrId;
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
     * @return Zorders
     */
    public function setZoneId(?int $zoneId): Zorders
    {
        $this->zoneId = $zoneId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInner(): ?string
    {
        return $this->inner;
    }

    /**
     * @param string|null $inner
     * @return Zorders
     */
    public function setInner(?string $inner): Zorders
    {
        $this->inner = $inner;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTime1(): ?string
    {
        return $this->time1;
    }

    /**
     * @param string|null $time1
     * @return Zorders
     */
    public function setTime1(?string $time1): Zorders
    {
        $this->time1 = $time1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTime2(): ?string
    {
        return $this->time2;
    }

    /**
     * @param string|null $time2
     * @return Zorders
     */
    public function setTime2(?string $time2): Zorders
    {
        $this->time2 = $time2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZcomments(): ?string
    {
        return $this->zcomments;
    }

    /**
     * @param string|null $zcomments
     * @return Zorders
     */
    public function setZcomments(?string $zcomments): Zorders
    {
        $this->zcomments = $zcomments;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getisPay(): ?int
    {
        return $this->isPay;
    }

    /**
     * @param int|null $isPay
     * @return Zorders
     */
    public function setIsPay(?int $isPay): Zorders
    {
        $this->isPay = $isPay;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getZpvzId(): ?int
    {
        return $this->zpvzId;
    }

    /**
     * @param int|null $zpvzId
     * @return Zorders
     */
    public function setZpvzId(?int $zpvzId): Zorders
    {
        $this->zpvzId = $zpvzId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZprice(): ?string
    {
        return $this->zprice;
    }

    /**
     * @param string|null $zprice
     * @return Zorders
     */
    public function setZprice(?string $zprice): Zorders
    {
        $this->zprice = $zprice;
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
     * @return Zorders
     */
    public function setBillId(?string $billId): Zorders
    {
        $this->billId = $billId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string|null $weight
     * @return Zorders
     */
    public function setWeight(?string $weight): Zorders
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCap(): ?string
    {
        return $this->cap;
    }

    /**
     * @param string|null $cap
     * @return Zorders
     */
    public function setCap(?string $cap): Zorders
    {
        $this->cap = $cap;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCrCost(): ?string
    {
        return $this->crCost;
    }

    /**
     * @param string|null $crCost
     * @return Zorders
     */
    public function setCrCost(?string $crCost): Zorders
    {
        $this->crCost = $crCost;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCarType(): ?int
    {
        return $this->carType;
    }

    /**
     * @param int|null $carType
     * @return Zorders
     */
    public function setCarType(?int $carType): Zorders
    {
        $this->carType = $carType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerenos(): ?int
    {
        return $this->perenos;
    }

    /**
     * @param int|null $perenos
     * @return Zorders
     */
    public function setPerenos(?int $perenos): Zorders
    {
        $this->perenos = $perenos;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerenosMark(): ?int
    {
        return $this->perenosMark;
    }

    /**
     * @param int|null $perenosMark
     * @return Zorders
     */
    public function setPerenosMark(?int $perenosMark): Zorders
    {
        $this->perenosMark = $perenosMark;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getChangeDate(): ?DateTime
    {
        return $this->changeDate;
    }

    /**
     * @param DateTime|null $changeDate
     * @return Zorders
     */
    public function setChangeDate(?DateTime $changeDate): Zorders
    {
        $this->changeDate = $changeDate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVozvratmark(): ?int
    {
        return $this->vozvratmark;
    }

    /**
     * @param int|null $vozvratmark
     * @return Zorders
     */
    public function setVozvratmark(?int $vozvratmark): Zorders
    {
        $this->vozvratmark = $vozvratmark;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPlacesCount(): ?int
    {
        return $this->placesCount;
    }

    /**
     * @param int|null $placesCount
     * @return Zorders
     */
    public function setPlacesCount(?int $placesCount): Zorders
    {
        $this->placesCount = $placesCount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVaktPart(): ?string
    {
        return $this->vaktPart;
    }

    /**
     * @param string|null $vaktPart
     * @return Zorders
     */
    public function setVaktPart(?string $vaktPart): Zorders
    {
        $this->vaktPart = $vaktPart;
        return $this;
    }

    /**
     * @return ZordersStatusModel
     */
    public function getStatus(): ZordersStatusModel
    {
        return $this->status;
    }

    /**
     * @param ZordersStatusModel $status
     * @return Zorders
     */
    public function setStatus(ZordersStatusModel $status): Zorders
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return ZordersStocksOurModel
     */
    public function getStockOur(): ZordersStocksOurModel
    {
        return $this->stockOur;
    }

    /**
     * @param ZordersStocksOurModel $stockOur
     * @return Zorders
     */
    public function setStockOur(?ZordersStocksOurModel $stockOur): Zorders
    {
        $this->stockOur = $stockOur;
        return $this;
    }

    /**
     * @return ZordersStocksModels
     */
    public function getStock(): ZordersStocksModels
    {
        return $this->stock;
    }

    /**
     * @param ZordersStocksModels $stock
     * @return Zorders
     */
    public function setStock(?ZordersStocksModels $stock): Zorders
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @return ZordersTypesModel
     */
    public function getType(): ZordersTypesModel
    {
        return $this->type;
    }

    /**
     * @param ZordersTypesModel $type
     * @return Zorders
     */
    public function setType(?ZordersTypesModel $type): Zorders
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return ZordersVaktPartStatusModel
     */
    public function getVaktPartStatus(): ZordersVaktPartStatusModel
    {
        return $this->vaktPartStatus;
    }

    /**
     * @param ZordersVaktPartStatusModel $vaktPartStatus
     * @return Zorders
     */
    public function setVaktPartStatus(ZordersVaktPartStatusModel $vaktPartStatus): Zorders
    {
        $this->vaktPartStatus = $vaktPartStatus;
        return $this;
    }

}
