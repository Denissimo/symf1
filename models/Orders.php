<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="oid", columns={"old_id"}), @ORM\Index(name="order_status", columns={"status"}), @ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="orders_address_id", columns={"address_id"}), @ORM\Index(name="order_id", columns={"order_id"}), @ORM\Index(name="order_type", columns={"type"}), @ORM\Index(name="pimpay_status", columns={"pimpay_status"})})
 * @ORM\Entity
 */
class Orders
{
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
    private $card = '0';

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
    private $chweightflag = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="update_date_flag", type="integer", nullable=true, options={"comment"="опция b2cpl - но уберем"})
     */
    private $updateDateFlag = '0';

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
    private $callOption = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="label_option", type="integer", nullable=true, options={"comment"="этикирование"})
     */
    private $labelOption = '0';

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
    private $docsOption = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="docs_return_option", type="integer", nullable=true, options={"comment"="Возврат накладной"})
     */
    private $docsReturnOption = '0';

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
    private $dressFittingOption = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="lifting_option", type="integer", nullable=true, options={"comment"="подъем"})
     */
    private $liftingOption = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="cargo_lift", type="integer", nullable=true, options={"comment"="наличие лифта"})
     */
    private $cargoLift = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="change_option", type="integer", nullable=true, options={"comment"="обмен"})
     */
    private $changeOption = '0';

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


}
