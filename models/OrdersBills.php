<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersBills
 *
 * @ORM\Table(name="orders_bills", uniqueConstraints={@ORM\UniqueConstraint(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class OrdersBills
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
     * @ORM\Column(name="price_courier", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Цена курьера"})
     */
    private $priceCourier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price_goods", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Оценочная стоимость"})
     */
    private $priceGoods;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price_client", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Наложеный платеж"})
     */
    private $priceClient;

    /**
     * @var string|null
     *
     * @ORM\Column(name="os", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Оценочная стоимость"})
     */
    private $os;

    /**
     * @var float|null
     *
     * @ORM\Column(name="dimension_side1", type="float", precision=10, scale=0, nullable=true, options={"default"="10","comment"="Габарит 1"})
     */
    private $dimensionSide1 = '10';

    /**
     * @var float|null
     *
     * @ORM\Column(name="dimension_side2", type="float", precision=10, scale=0, nullable=true, options={"default"="10","comment"="Габарит 2"})
     */
    private $dimensionSide2 = '10';

    /**
     * @var float|null
     *
     * @ORM\Column(name="dimension_side3", type="float", precision=10, scale=0, nullable=true, options={"default"="10","comment"="Габарит 3"})
     */
    private $dimensionSide3 = '10';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_tar", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Тариф доставки"})
     */
    private $pdTar = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_ko", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Кассовое обслуживание, руб"})
     */
    private $pdKo = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_dop", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Сумм. доп. услуги, руб"})
     */
    private $pdDop = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_dop_strah", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Страхование, руб"})
     */
    private $pdDopStrah = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_dop_compl", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Комплектация, руб"})
     */
    private $pdDopCompl = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_eq", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Эквайринг, руб"})
     */
    private $pdEq = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_call", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Прозвон, руб"})
     */
    private $pdCall = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_sms", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="смс, руб"})
     */
    private $pdSms = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_label", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="этикирование, руб"})
     */
    private $pdLabel = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_docs", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="вложение накл., руб"})
     */
    private $pdDocs = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_docs_return", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="возврат док., руб"})
     */
    private $pdDocsReturn = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_change", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="обмен, руб"})
     */
    private $pdChange = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_dop_pack", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Упаковка, руб"})
     */
    private $pdDopPack = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_dop_vozvrat", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Обработка возврата, руб"})
     */
    private $pdDopVozvrat = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="price_delivery", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Полная стоимость услуг, руб"})
     */
    private $priceDelivery;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sum2p", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Сумма к передаче ИМ"})
     */
    private $sum2p;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price_client_delivery", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Стоимость доставки для конечного потребителя"})
     */
    private $priceClientDelivery;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agent_cost", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $agentCost;

    /**
     * @var string|null
     *
     * @ORM\Column(name="change_os", type="decimal", precision=9, scale=2, nullable=true, options={"default"="1.00","comment"="оценочная обмена"})
     */
    private $changeOs = '1.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="change_weight", type="decimal", precision=9, scale=3, nullable=true, options={"default"="1.000","comment"="вес обмена"})
     */
    private $changeWeight = '1.000';

    /**
     * @var \Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;


}
