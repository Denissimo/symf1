<?php


use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="order_id", columns={"order_id"}), @ORM\Index(name="order_type", columns={"type"}), @ORM\Index(name="order_bill_id", columns={"order_bill_id"}), @ORM\Index(name="order_settings_id", columns={"order_settings_id"}), @ORM\Index(name="oid", columns={"old_id"}), @ORM\Index(name="order_status", columns={"status"}), @ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="orders_address_id", columns={"address_id"})})
 * @ORM\Entity
 */
class Orders extends Model
{

    const
        CLIENT = 'client',
        GHANGEDATE = 'updated',
        OLDID = 'oldId',
        ID = 'id',
        INNER_N = 'innerN',
        ORDER_ID = 'orderId';

    /** @var string - формат хранения даты доставки */
    const DELIVERY_DATE_FORMAT = 'Y-m-d';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment"="AI"})
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
     * @var string
     *
     * @ORM\Column(name="order_id", type="string", length=256, nullable=false, options={"comment"="Номер заказа"})
     */
    private $orderId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_add", type="date", nullable=true, options={"comment"="Дата добавления"})
     */
    private $dateAdd;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true, options={"comment"="Дата изменения"})
     */
    private $updated;
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="change_date", type="datetime", nullable=true, options={"comment"="Дата изменения"})
     */
    private $changeDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="delivery_date", type="date", nullable=true, options={"comment"="Дата доставки"})
     */
    private $deliveryDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="delivery_time", type="integer", nullable=true, options={"comment"="Время доставки"})
     */
    private $deliveryTime;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="delivery_time1", type="time", nullable=true, options={"comment"="Время доставки-начало"})
     */
    private $deliveryTime1;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="delivery_time2", type="time", nullable=true, options={"comment"="Время доставки-конец"})
     */
    private $deliveryTime2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="target_name", type="string", length=256, nullable=true, options={"comment"="Имя получателя"})
     */
    private $targetName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="courier_id", type="integer", nullable=true, options={"comment"="id Курьера"})
     */
    private $courierId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cour_cid", type="integer", nullable=true, options={"comment"="id Курьера текущего"})
     */
    private $courCid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="target_contacts", type="string", length=256, nullable=true, options={"comment"="Номер получателя"})
     */
    private $targetContacts;

    /**
     * @var string|null
     *
     * @ORM\Column(name="target_notes", type="string", length=256, nullable=true, options={"comment"="Примечания ИМ к заказу"})
     */
    private $targetNotes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adm_notes", type="string", length=256, nullable=true, options={"comment"="Примечания КС к заказу"})
     */
    private $admNotes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="agent_id", type="integer", nullable=true, options={"comment"="id Партнера"})
     */
    private $agentId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="manager_id", type="integer", nullable=true, options={"comment"="id Менеджера"})
     */
    private $managerId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="otkazmark", type="integer", nullable=true)
     */
    private $otkazmark;

    /**
     * @var int|null
     *
     * @ORM\Column(name="p_reason", type="integer", nullable=true, options={"comment"="id причины переноса"})
     */
    private $pReason;

    /**
     * @var int|null
     *
     * @ORM\Column(name="c_reason", type="integer", nullable=true, options={"comment"="id причины отмены"})
     */
    private $cReason;

    /**
     * @var string|null
     *
     * @ORM\Column(name="inner_n", type="string", length=256, nullable=true, options={"comment"="Внутренний номер заказа"})
     */
    private $innerN;

    /**
     * @var string|null
     *
     * @ORM\Column(name="brand", type="string", length=256, nullable=true, options={"comment"="Брэнд"})
     */
    private $brand;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shk", type="string", length=256, nullable=true, options={"comment"="Штрихкод отправления"})
     */
    private $shk;

    /**
     * @var string|null
     *
     * @ORM\Column(name="order_weight", type="string", length=256, nullable=true, options={"default"="0.1","comment"="Вес заказа"})
     */
    private $orderWeight = '0.1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="update_date_flag", type="integer", nullable=true, options={"comment"="опция b2cpl - но уберем"})
     */
    private $updateDateFlag;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bill_id", type="string", length=256, nullable=true, options={"comment"="id Отчета"})
     */
    private $billId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="akt_id", type="string", length=256, nullable=true, options={"comment"="id Акта ПП"})
     */
    private $aktId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reg_bill_id", type="string", length=256, nullable=true, options={"comment"="id Акта оплаты регионов"})
     */
    private $regBillId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="places_count", type="integer", nullable=true, options={"default"="1","comment"="Количество мест в заказе"})
     */
    private $placesCount = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="orderPlace", type="integer", nullable=true, options={"comment"="Сортировка для мобильных телефонов"})
     */
    private $orderplace;

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
     * @var \OrdersBills
     *
     * @ORM\ManyToOne(targetEntity="OrdersBills")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_bill_id", referencedColumnName="id")
     * })
     */
    private $orderBill;

    /**
     * @var \OrdersSettings
     *
     * @ORM\ManyToOne(targetEntity="OrdersSettings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_settings_id", referencedColumnName="id")
     * })
     */
    private $orderSettings;

    /**
     * @var \OrdersStatusModel
     *
     * @ORM\ManyToOne(targetEntity="OrdersStatusModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var \OrdersTypesModel
     *
     * @ORM\ManyToOne(targetEntity="OrdersTypesModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var \Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * })
     */
    private $address;


    /**
     * @var int|null
     *
     * @ORM\Column(name="geo_id", type="integer", nullable=true)
     */
    private $geoId;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Goods", mappedBy="order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="order_id")
     * })
     */
    private $goods;

    /**
     * @var string|null
     *
     * @ORM\Column(name="change_weight", type="decimal", precision=9, scale=3, nullable=true, options={"default"="1.000","comment"="вес обмена"})
     */
    private $changeWeight = '1.000';

    /**
     * @return Collection
     */
    public function getGoods(): Collection
    {
        return $this->goods;
    }

    /**
     * @param Collection $goods
     * @return Orders
     */
    public function setGoods(Collection $goods): Orders
    {
        $this->goods = $goods;
        return $this;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Orders
     */
    public function setId(int $id): Orders
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
     * @return Orders
     */
    public function setOldId(?int $oldId): Orders
    {
        $this->oldId = $oldId;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     * @return Orders
     */
    public function setOrderId(string $orderId): Orders
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateAdd(): ?DateTime
    {
        return $this->dateAdd;
    }

    /**
     * @param DateTime|null $dateAdd
     * @return Orders
     */
    public function setDateAdd(?DateTime $dateAdd): Orders
    {
        $this->dateAdd = $dateAdd;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime|null $updated
     * @return Orders
     */
    public function setUpdated(?DateTime $updated): Orders
    {
        $this->updated = $updated;
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
     * @return Orders
     */
    public function setChangeDate(?DateTime $changeDate): Orders
    {
        $this->changeDate = $changeDate;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDeliveryDate(): ?DateTime
    {
        return $this->deliveryDate;
    }

    /**
     * @param DateTime|null $deliveryDate
     * @return Orders
     */
    public function setDeliveryDate(?DateTime $deliveryDate): Orders
    {
        $this->deliveryDate = $deliveryDate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDeliveryTime(): ?int
    {
        return $this->deliveryTime;
    }

    /**
     * @param int|null $deliveryTime
     * @return Orders
     */
    public function setDeliveryTime(?int $deliveryTime): Orders
    {
        $this->deliveryTime = $deliveryTime;
        return $this;
    }


    /**
     * @return DateTime|null
     */
    public function getDeliveryTime1(): ?DateTime
    {
        return $this->deliveryTime1;
    }

    /**
     * @param DateTime|null $deliveryTime1
     * @return Orders
     */
    public function setDeliveryTime1(?DateTime $deliveryTime1): Orders
    {
        $this->deliveryTime1 = $deliveryTime1;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDeliveryTime2(): ?DateTime
    {
        return $this->deliveryTime2;
    }

    /**
     * @param DateTime|null $deliveryTime2
     * @return Orders
     */
    public function setDeliveryTime2(?DateTime $deliveryTime2): Orders
    {
        $this->deliveryTime2 = $deliveryTime2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTargetName(): ?string
    {
        return $this->targetName;
    }

    /**
     * @param string|null $targetName
     * @return Orders
     */
    public function setTargetName(?string $targetName): Orders
    {
        $this->targetName = $targetName;
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
     * @return Orders
     */
    public function setCourierId(?int $courierId): Orders
    {
        $this->courierId = $courierId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCourCid(): ?int
    {
        return $this->courCid;
    }

    /**
     * @param int|null $courCid
     * @return Orders
     */
    public function setCourCid(?int $courCid): Orders
    {
        $this->courCid = $courCid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTargetContacts(): ?string
    {
        return $this->targetContacts;
    }

    /**
     * @param string|null $targetContacts
     * @return Orders
     */
    public function setTargetContacts(?string $targetContacts): Orders
    {
        $this->targetContacts = $targetContacts;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTargetNotes(): ?string
    {
        return $this->targetNotes;
    }

    /**
     * @param string|null $targetNotes
     * @return Orders
     */
    public function setTargetNotes(?string $targetNotes): Orders
    {
        $this->targetNotes = $targetNotes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdmNotes(): ?string
    {
        return $this->admNotes;
    }

    /**
     * @param string|null $admNotes
     * @return Orders
     */
    public function setAdmNotes(?string $admNotes): Orders
    {
        $this->admNotes = $admNotes;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAgentId(): ?int
    {
        return $this->agentId;
    }

    /**
     * @param int|null $agentId
     * @return Orders
     */
    public function setAgentId(?int $agentId): Orders
    {
        $this->agentId = $agentId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getManagerId(): ?int
    {
        return $this->managerId;
    }

    /**
     * @param int|null $managerId
     * @return Orders
     */
    public function setManagerId(?int $managerId): Orders
    {
        $this->managerId = $managerId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOtkazmark(): ?int
    {
        return $this->otkazmark;
    }

    /**
     * @param int|null $otkazmark
     * @return Orders
     */
    public function setOtkazmark(?int $otkazmark): Orders
    {
        $this->otkazmark = $otkazmark;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPReason(): ?int
    {
        return $this->pReason;
    }

    /**
     * @param int|null $pReason
     * @return Orders
     */
    public function setPReason(?int $pReason): Orders
    {
        $this->pReason = $pReason;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCReason()
    {
        return $this->cReason;
    }

    /**
     * @param int|null $cReason
     * @return Orders
     */
    public function setCReason($cReason) : Orders
    {
        $this->cReason = $cReason;
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
     * @return Orders
     */
    public function setInnerN(?string $innerN): Orders
    {
        $this->innerN = $innerN;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     * @return Orders
     */
    public function setBrand(?string $brand): Orders
    {
        $this->brand = $brand;
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
     * @return Orders
     */
    public function setShk(?string $shk): Orders
    {
        $this->shk = $shk;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderWeight(): ?string
    {
        return $this->orderWeight;
    }

    /**
     * @param string|null $orderWeight
     * @return Orders
     */
    public function setOrderWeight(?string $orderWeight): Orders
    {
        $this->orderWeight = $orderWeight;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUpdateDateFlag(): ?int
    {
        return $this->updateDateFlag;
    }

    /**
     * @param int|null $updateDateFlag
     * @return Orders
     */
    public function setUpdateDateFlag(?int $updateDateFlag): Orders
    {
        $this->updateDateFlag = $updateDateFlag;
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
     * @return Orders
     */
    public function setBillId(?string $billId): Orders
    {
        $this->billId = $billId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAktId(): ?string
    {
        return $this->aktId;
    }

    /**
     * @param string|null $aktId
     * @return Orders
     */
    public function setAktId(?string $aktId): Orders
    {
        $this->aktId = $aktId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegBillId(): ?string
    {
        return $this->regBillId;
    }

    /**
     * @param string|null $regBillId
     * @return Orders
     */
    public function setRegBillId(?string $regBillId): Orders
    {
        $this->regBillId = $regBillId;
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
     * @return Orders
     */
    public function setPlacesCount(?int $placesCount): Orders
    {
        $this->placesCount = $placesCount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderplace(): ?int
    {
        return $this->orderplace;
    }

    /**
     * @param int|null $orderplace
     * @return Orders
     */
    public function setOrderplace(?int $orderplace): Orders
    {
        $this->orderplace = $orderplace;
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
     * @return Orders
     */
    public function setClient(ClientSettings $client): Orders
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return OrdersBills
     */
    public function getOrderBill(): OrdersBills
    {
        return $this->orderBill;
    }

    /**
     * @param OrdersBills $orderBill
     * @return Orders
     */
    public function setOrderBill(OrdersBills $orderBill): Orders
    {
        $this->orderBill = $orderBill;
        return $this;
    }

    /**
     * @return OrdersSettings
     */
    public function getOrderSettings(): OrdersSettings
    {
        return $this->orderSettings;
    }

    /**
     * @param OrdersSettings $orderSettings
     * @return Orders
     */
    public function setOrderSettings(OrdersSettings $orderSettings): Orders
    {
        $this->orderSettings = $orderSettings;
        return $this;
    }

    /**
     * @return OrdersStatusModel
     */
    public function getStatus(): OrdersStatusModel
    {
        return $this->status;
    }

    /**
     * @param OrdersStatusModel $status
     * @return Orders
     */
    public function setStatus(OrdersStatusModel $status): Orders
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return OrdersTypesModel
     */
    public function getType(): OrdersTypesModel
    {
        return $this->type;
    }

    /**
     * @param OrdersTypesModel $type
     * @return Orders
     */
    public function setType(OrdersTypesModel $type): Orders
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return Orders
     */
    public function setAddress(Address $address): Orders
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGeoId(): ?int
    {
        return $this->geoId;
    }

    /**
     * @param int|null $geoId
     * @return Orders
     */
    public function setGeoId(?int $geoId): Orders
    {
        $this->geoId = $geoId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChangeWeight(): ?string
    {
        return $this->changeWeight;
    }

    /**
     * @param string|null $changeWeight
     * @return Orders
     */
    public function setChangeWeight(?string $changeWeight): Orders
    {
        $this->changeWeight = $changeWeight;
        return $this;
    }

}
