<?php


use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="order_id", columns={"order_id"}), @ORM\Index(name="order_type", columns={"type"}), @ORM\Index(name="pimpay_status", columns={"pimpay_status"}), @ORM\Index(name="order_bill_id", columns={"order_bill_id"}), @ORM\Index(name="order_settings_id", columns={"order_settings_id"}), @ORM\Index(name="oid", columns={"old_id"}), @ORM\Index(name="order_status", columns={"status"}), @ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="orders_address_id", columns={"address_id"})})
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
     * @ORM\Column(name="nds_price_client", type="integer", nullable=true)
     */
    private $ndsPriceClient;

    /**
     * @var string|null
     *
     * @ORM\Column(name="is_packed", type="string", length=256, nullable=true, options={"comment"="Флажок упаковки"})
     */
    private $isPacked;

    /**
     * @var string|null
     *
     * @ORM\Column(name="np", type="string", length=256, nullable=true, options={"comment"="Флажок НП"})
     */
    private $np;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sms", type="string", length=256, nullable=true, options={"comment"="SMS"})
     */
    private $sms;

    /**
     * @var string|null
     *
     * @ORM\Column(name="is_complect", type="string", length=256, nullable=true, options={"comment"="Флажок комплектации"})
     */
    private $isComplect;

    /**
     * @var int|null
     *
     * @ORM\Column(name="card", type="integer", nullable=true, options={"comment"="оплата картой"})
     */
    private $card;

    /**
     * @var int|null
     *
     * @ORM\Column(name="card_type", type="integer", nullable=true, options={"comment"="1-mastercard, 2-visa, 3-мир"})
     */
    private $cardType;

    /**
     * @var int|null
     *
     * @ORM\Column(name="agent_id", type="integer", nullable=true, options={"comment"="id Партнера"})
     */
    private $agentId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agent_act", type="string", length=256, nullable=true)
     */
    private $agentAct;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agent_vact", type="string", length=256, nullable=true)
     */
    private $agentVact;

    /**
     * @var int|null
     *
     * @ORM\Column(name="manager_id", type="integer", nullable=true, options={"comment"="id Менеджера"})
     */
    private $managerId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="isoh", type="integer", nullable=true)
     */
    private $isoh;

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
     * @var int|null
     *
     * @ORM\Column(name="reason_7", type="integer", nullable=true, options={"comment"="id статус отказ на месте"})
     */
    private $reason7;

    /**
     * @var int|null
     *
     * @ORM\Column(name="reason_8", type="integer", nullable=true, options={"comment"="id причины отмены"})
     */
    private $reason8;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ordercall", type="integer", nullable=true, options={"comment"="опция хз"})
     */
    private $ordercall;

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
     * @ORM\Column(name="chweightflag", type="integer", nullable=true, options={"comment"="опция Максипост"})
     */
    private $chweightflag;

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
     * @var string|null
     *
     * @ORM\Column(name="partner_act", type="string", length=256, nullable=true, options={"comment"="reserved"})
     */
    private $partnerAct;

    /**
     * @var int|null
     *
     * @ORM\Column(name="open_option", type="integer", nullable=true, options={"default"="1","comment"="Вскрытие"})
     */
    private $openOption = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="call_option", type="integer", nullable=true, options={"comment"="Предварительный прозвон"})
     */
    private $callOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="label_option", type="integer", nullable=true, options={"comment"="этикирование"})
     */
    private $labelOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="places_count", type="integer", nullable=true, options={"default"="1","comment"="Количество мест в заказе"})
     */
    private $placesCount = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="docs_option", type="integer", nullable=true, options={"comment"="Вложение накладной"})
     */
    private $docsOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="docs_return_option", type="integer", nullable=true, options={"comment"="Возврат накладной"})
     */
    private $docsReturnOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="partial_option", type="integer", nullable=true, options={"default"="1","comment"="Ч.о."})
     */
    private $partialOption = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="dress_fitting_option", type="integer", nullable=true, options={"comment"="примерка"})
     */
    private $dressFittingOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="lifting_option", type="integer", nullable=true, options={"comment"="подъем"})
     */
    private $liftingOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cargo_lift", type="integer", nullable=true, options={"comment"="наличие лифта"})
     */
    private $cargoLift;

    /**
     * @var int|null
     *
     * @ORM\Column(name="change_option", type="integer", nullable=true, options={"comment"="обмен"})
     */
    private $changeOption;

    /**
     * @var string|null
     *
     * @ORM\Column(name="change_text", type="text", length=0, nullable=true, options={"comment"="текст обмена"})
     */
    private $changeText;

    /**
     * @var int|null
     *
     * @ORM\Column(name="orderPlace", type="integer", nullable=true, options={"comment"="Сортировка для мобильных телефонов"})
     */
    private $orderplace;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pimp_send", type="integer", nullable=true, options={"comment"="1-done, 0-not transfer"})
     */
    private $pimpSend;

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
     * @var \OrdersPimpayModel
     *
     * @ORM\ManyToOne(targetEntity="OrdersPimpayModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pimpay_status", referencedColumnName="id")
     * })
     */
    private $pimpayStatus;

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
    public function getNdsPriceClient(): ?int
    {
        return $this->ndsPriceClient;
    }

    /**
     * @param int|null $ndsPriceClient
     * @return Orders
     */
    public function setNdsPriceClient(?int $ndsPriceClient): Orders
    {
        $this->ndsPriceClient = $ndsPriceClient;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getisPacked(): ?string
    {
        return $this->isPacked;
    }

    /**
     * @param string|null $isPacked
     * @return Orders
     */
    public function setIsPacked(?string $isPacked): Orders
    {
        $this->isPacked = $isPacked;
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
     * @return Orders
     */
    public function setNp(?string $np): Orders
    {
        $this->np = $np;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSms(): ?string
    {
        return $this->sms;
    }

    /**
     * @param string|null $sms
     * @return Orders
     */
    public function setSms(?string $sms): Orders
    {
        $this->sms = $sms;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getisComplect(): ?string
    {
        return $this->isComplect;
    }

    /**
     * @param string|null $isComplect
     * @return Orders
     */
    public function setIsComplect(?string $isComplect): Orders
    {
        $this->isComplect = $isComplect;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCard(): ?int
    {
        return $this->card;
    }

    /**
     * @param int|null $card
     * @return Orders
     */
    public function setCard(?int $card): Orders
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCardType(): ?int
    {
        return $this->cardType;
    }

    /**
     * @param int|null $cardType
     * @return Orders
     */
    public function setCardType(?int $cardType): Orders
    {
        $this->cardType = $cardType;
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
     * @return string|null
     */
    public function getAgentAct(): ?string
    {
        return $this->agentAct;
    }

    /**
     * @param string|null $agentAct
     * @return Orders
     */
    public function setAgentAct(?string $agentAct): Orders
    {
        $this->agentAct = $agentAct;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAgentVact(): ?string
    {
        return $this->agentVact;
    }

    /**
     * @param string|null $agentVact
     * @return Orders
     */
    public function setAgentVact(?string $agentVact): Orders
    {
        $this->agentVact = $agentVact;
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
    public function getIsoh(): ?int
    {
        return $this->isoh;
    }

    /**
     * @param int|null $isoh
     * @return Orders
     */
    public function setIsoh(?int $isoh): Orders
    {
        $this->isoh = $isoh;
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
     * @return int|null
     */
    public function getReason7(): ?int
    {
        return $this->reason7;
    }

    /**
     * @param int|null $reason7
     * @return Orders
     */
    public function setReason7(?int $reason7): Orders
    {
        $this->reason7 = $reason7;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getReason8(): ?int
    {
        return $this->reason8;
    }

    /**
     * @param int|null $reason8
     * @return Orders
     */
    public function setReason8(?int $reason8): Orders
    {
        $this->reason8 = $reason8;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrdercall(): ?int
    {
        return $this->ordercall;
    }

    /**
     * @param int|null $ordercall
     * @return Orders
     */
    public function setOrdercall(?int $ordercall): Orders
    {
        $this->ordercall = $ordercall;
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
    public function getChweightflag(): ?int
    {
        return $this->chweightflag;
    }

    /**
     * @param int|null $chweightflag
     * @return Orders
     */
    public function setChweightflag(?int $chweightflag): Orders
    {
        $this->chweightflag = $chweightflag;
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
     * @return string|null
     */
    public function getPartnerAct(): ?string
    {
        return $this->partnerAct;
    }

    /**
     * @param string|null $partnerAct
     * @return Orders
     */
    public function setPartnerAct(?string $partnerAct): Orders
    {
        $this->partnerAct = $partnerAct;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOpenOption(): ?int
    {
        return $this->openOption;
    }

    /**
     * @param int|null $openOption
     * @return Orders
     */
    public function setOpenOption(?int $openOption): Orders
    {
        $this->openOption = $openOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCallOption(): ?int
    {
        return $this->callOption;
    }

    /**
     * @param int|null $callOption
     * @return Orders
     */
    public function setCallOption(?int $callOption): Orders
    {
        $this->callOption = $callOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLabelOption(): ?int
    {
        return $this->labelOption;
    }

    /**
     * @param int|null $labelOption
     * @return Orders
     */
    public function setLabelOption(?int $labelOption): Orders
    {
        $this->labelOption = $labelOption;
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
    public function getDocsOption(): ?int
    {
        return $this->docsOption;
    }

    /**
     * @param int|null $docsOption
     * @return Orders
     */
    public function setDocsOption(?int $docsOption): Orders
    {
        $this->docsOption = $docsOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDocsReturnOption(): ?int
    {
        return $this->docsReturnOption;
    }

    /**
     * @param int|null $docsReturnOption
     * @return Orders
     */
    public function setDocsReturnOption(?int $docsReturnOption): Orders
    {
        $this->docsReturnOption = $docsReturnOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPartialOption(): ?int
    {
        return $this->partialOption;
    }

    /**
     * @param int|null $partialOption
     * @return Orders
     */
    public function setPartialOption(?int $partialOption): Orders
    {
        $this->partialOption = $partialOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDressFittingOption(): ?int
    {
        return $this->dressFittingOption;
    }

    /**
     * @param int|null $dressFittingOption
     * @return Orders
     */
    public function setDressFittingOption(?int $dressFittingOption): Orders
    {
        $this->dressFittingOption = $dressFittingOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLiftingOption(): ?int
    {
        return $this->liftingOption;
    }

    /**
     * @param int|null $liftingOption
     * @return Orders
     */
    public function setLiftingOption(?int $liftingOption): Orders
    {
        $this->liftingOption = $liftingOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCargoLift(): ?int
    {
        return $this->cargoLift;
    }

    /**
     * @param int|null $cargoLift
     * @return Orders
     */
    public function setCargoLift(?int $cargoLift): Orders
    {
        $this->cargoLift = $cargoLift;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getChangeOption(): ?int
    {
        return $this->changeOption;
    }

    /**
     * @param int|null $changeOption
     * @return Orders
     */
    public function setChangeOption(?int $changeOption): Orders
    {
        $this->changeOption = $changeOption;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChangeText(): ?string
    {
        return $this->changeText;
    }

    /**
     * @param string|null $changeText
     * @return Orders
     */
    public function setChangeText(?string $changeText): Orders
    {
        $this->changeText = $changeText;
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
     * @return int|null
     */
    public function getPimpSend(): ?int
    {
        return $this->pimpSend;
    }

    /**
     * @param int|null $pimpSend
     * @return Orders
     */
    public function setPimpSend(?int $pimpSend): Orders
    {
        $this->pimpSend = $pimpSend;
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
     * @return OrdersPimpayModel
     */
    public function getPimpayStatus(): OrdersPimpayModel
    {
        return $this->pimpayStatus;
    }

    /**
     * @param OrdersPimpayModel $pimpayStatus
     * @return Orders
     */
    public function setPimpayStatus(OrdersPimpayModel $pimpayStatus): Orders
    {
        $this->pimpayStatus = $pimpayStatus;
        return $this;
    }

}
