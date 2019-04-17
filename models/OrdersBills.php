<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersBills
 *
 * @ORM\Table(name="orders_bills")
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
     * @ORM\Column(name="pd_eq", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Эквайринг, руб"})
     */
    private $pdEq = '0.00';

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
     * @var int|null
     *
     * @ORM\Column(name="nds_price_client", type="integer", nullable=true)
     */
    private $ndsPriceClient;


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
     * @ORM\Column(name="pimp_send", type="integer", nullable=true, options={"comment"="1-done, 0-not transfer"})
     */
    private $pimpSend;

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
     * @return int|null
     */
    public function getNdsPriceClient(): ?int
    {
        return $this->ndsPriceClient;
    }

    /**
     * @param int|null $ndsPriceClient
     * @return OrdersBills
     */
    public function setNdsPriceClient(?int $ndsPriceClient): OrdersBills
    {
        $this->ndsPriceClient = $ndsPriceClient;
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
     * @return OrdersBills
     */
    public function setCard(?int $card): OrdersBills
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
     * @return OrdersBills
     */
    public function setCardType(?int $cardType): OrdersBills
    {
        $this->cardType = $cardType;
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
     * @return OrdersBills
     */
    public function setPimpSend(?int $pimpSend): OrdersBills
    {
        $this->pimpSend = $pimpSend;
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
     * @return OrdersBills
     */
    public function setPimpayStatus(OrdersPimpayModel $pimpayStatus): OrdersBills
    {
        $this->pimpayStatus = $pimpayStatus;
        return $this;
    }


}
