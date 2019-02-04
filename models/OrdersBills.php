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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersBills
     */
    public function setId(int $id): OrdersBills
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceCourier(): ?string
    {
        return $this->priceCourier;
    }

    /**
     * @param string|null $priceCourier
     * @return OrdersBills
     */
    public function setPriceCourier(?string $priceCourier): OrdersBills
    {
        $this->priceCourier = $priceCourier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceGoods(): ?string
    {
        return $this->priceGoods;
    }

    /**
     * @param string|null $priceGoods
     * @return OrdersBills
     */
    public function setPriceGoods(?string $priceGoods): OrdersBills
    {
        $this->priceGoods = $priceGoods;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceClient(): ?string
    {
        return $this->priceClient;
    }

    /**
     * @param string|null $priceClient
     * @return OrdersBills
     */
    public function setPriceClient(?string $priceClient): OrdersBills
    {
        $this->priceClient = $priceClient;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOs(): ?string
    {
        return $this->os;
    }

    /**
     * @param string|null $os
     * @return OrdersBills
     */
    public function setOs(?string $os): OrdersBills
    {
        $this->os = $os;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getDimensionSide1(): ?float
    {
        return $this->dimensionSide1;
    }

    /**
     * @param float|null $dimensionSide1
     * @return OrdersBills
     */
    public function setDimensionSide1(?float $dimensionSide1): OrdersBills
    {
        $this->dimensionSide1 = $dimensionSide1;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getDimensionSide2(): ?float
    {
        return $this->dimensionSide2;
    }

    /**
     * @param float|null $dimensionSide2
     * @return OrdersBills
     */
    public function setDimensionSide2(?float $dimensionSide2): OrdersBills
    {
        $this->dimensionSide2 = $dimensionSide2;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getDimensionSide3(): ?float
    {
        return $this->dimensionSide3;
    }

    /**
     * @param float|null $dimensionSide3
     * @return OrdersBills
     */
    public function setDimensionSide3(?float $dimensionSide3): OrdersBills
    {
        $this->dimensionSide3 = $dimensionSide3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdTar(): ?string
    {
        return $this->pdTar;
    }

    /**
     * @param string|null $pdTar
     * @return OrdersBills
     */
    public function setPdTar(?string $pdTar): OrdersBills
    {
        $this->pdTar = $pdTar;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdKo(): ?string
    {
        return $this->pdKo;
    }

    /**
     * @param string|null $pdKo
     * @return OrdersBills
     */
    public function setPdKo(?string $pdKo): OrdersBills
    {
        $this->pdKo = $pdKo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdDop(): ?string
    {
        return $this->pdDop;
    }

    /**
     * @param string|null $pdDop
     * @return OrdersBills
     */
    public function setPdDop(?string $pdDop): OrdersBills
    {
        $this->pdDop = $pdDop;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdDopStrah(): ?string
    {
        return $this->pdDopStrah;
    }

    /**
     * @param string|null $pdDopStrah
     * @return OrdersBills
     */
    public function setPdDopStrah(?string $pdDopStrah): OrdersBills
    {
        $this->pdDopStrah = $pdDopStrah;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdDopCompl(): ?string
    {
        return $this->pdDopCompl;
    }

    /**
     * @param string|null $pdDopCompl
     * @return OrdersBills
     */
    public function setPdDopCompl(?string $pdDopCompl): OrdersBills
    {
        $this->pdDopCompl = $pdDopCompl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdEq(): ?string
    {
        return $this->pdEq;
    }

    /**
     * @param string|null $pdEq
     * @return OrdersBills
     */
    public function setPdEq(?string $pdEq): OrdersBills
    {
        $this->pdEq = $pdEq;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdCall(): ?string
    {
        return $this->pdCall;
    }

    /**
     * @param string|null $pdCall
     * @return OrdersBills
     */
    public function setPdCall(?string $pdCall): OrdersBills
    {
        $this->pdCall = $pdCall;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdSms(): ?string
    {
        return $this->pdSms;
    }

    /**
     * @param string|null $pdSms
     * @return OrdersBills
     */
    public function setPdSms(?string $pdSms): OrdersBills
    {
        $this->pdSms = $pdSms;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdLabel(): ?string
    {
        return $this->pdLabel;
    }

    /**
     * @param string|null $pdLabel
     * @return OrdersBills
     */
    public function setPdLabel(?string $pdLabel): OrdersBills
    {
        $this->pdLabel = $pdLabel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdDocs(): ?string
    {
        return $this->pdDocs;
    }

    /**
     * @param string|null $pdDocs
     * @return OrdersBills
     */
    public function setPdDocs(?string $pdDocs): OrdersBills
    {
        $this->pdDocs = $pdDocs;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdDocsReturn(): ?string
    {
        return $this->pdDocsReturn;
    }

    /**
     * @param string|null $pdDocsReturn
     * @return OrdersBills
     */
    public function setPdDocsReturn(?string $pdDocsReturn): OrdersBills
    {
        $this->pdDocsReturn = $pdDocsReturn;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdChange(): ?string
    {
        return $this->pdChange;
    }

    /**
     * @param string|null $pdChange
     * @return OrdersBills
     */
    public function setPdChange(?string $pdChange): OrdersBills
    {
        $this->pdChange = $pdChange;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdDopPack(): ?string
    {
        return $this->pdDopPack;
    }

    /**
     * @param string|null $pdDopPack
     * @return OrdersBills
     */
    public function setPdDopPack(?string $pdDopPack): OrdersBills
    {
        $this->pdDopPack = $pdDopPack;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdDopVozvrat(): ?string
    {
        return $this->pdDopVozvrat;
    }

    /**
     * @param string|null $pdDopVozvrat
     * @return OrdersBills
     */
    public function setPdDopVozvrat(?string $pdDopVozvrat): OrdersBills
    {
        $this->pdDopVozvrat = $pdDopVozvrat;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceDelivery(): ?string
    {
        return $this->priceDelivery;
    }

    /**
     * @param string|null $priceDelivery
     * @return OrdersBills
     */
    public function setPriceDelivery(?string $priceDelivery): OrdersBills
    {
        $this->priceDelivery = $priceDelivery;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSum2p(): ?string
    {
        return $this->sum2p;
    }

    /**
     * @param string|null $sum2p
     * @return OrdersBills
     */
    public function setSum2p(?string $sum2p): OrdersBills
    {
        $this->sum2p = $sum2p;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceClientDelivery(): ?string
    {
        return $this->priceClientDelivery;
    }

    /**
     * @param string|null $priceClientDelivery
     * @return OrdersBills
     */
    public function setPriceClientDelivery(?string $priceClientDelivery): OrdersBills
    {
        $this->priceClientDelivery = $priceClientDelivery;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAgentCost(): ?string
    {
        return $this->agentCost;
    }

    /**
     * @param string|null $agentCost
     * @return OrdersBills
     */
    public function setAgentCost(?string $agentCost): OrdersBills
    {
        $this->agentCost = $agentCost;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChangeOs(): ?string
    {
        return $this->changeOs;
    }

    /**
     * @param string|null $changeOs
     * @return OrdersBills
     */
    public function setChangeOs(?string $changeOs): OrdersBills
    {
        $this->changeOs = $changeOs;
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
     * @return OrdersBills
     */
    public function setChangeWeight(?string $changeWeight): OrdersBills
    {
        $this->changeWeight = $changeWeight;
        return $this;
    }

    /**
     * @return Orders
     */
    public function getOrder(): Orders
    {
        return $this->order;
    }

    /**
     * @param Orders $order
     * @return OrdersBills
     */
    public function setOrder(Orders $order): OrdersBills
    {
        $this->order = $order;
        return $this;
    }


}
