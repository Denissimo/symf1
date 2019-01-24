<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Goods
 *
 * @ORM\Table(name="goods", indexes={@ORM\Index(name="goods_nds_type", columns={"goods_nds_type"}), @ORM\Index(name="FK_goods_goods_status", columns={"goods_status"}), @ORM\Index(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class Goods
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
     * @ORM\Column(name="article", type="string", length=256, nullable=true, options={"comment"="Бывший articul - Артикул клиента (заказа)"})
     */
    private $article;

    /**
     * @var string|null
     *
     * @ORM\Column(name="order_id", type="string", length=256, nullable=true, options={"comment"="Наш номер заказа в привязке к таблице ORDERS"})
     */
    private $orderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true, options={"comment"="artname - Бывший описание товара"})
     */
    private $description;

    /**
     * @var float|null
     *
     * @ORM\Column(name="weight", type="float", precision=10, scale=0, nullable=true, options={"comment"="Вес"})
     */
    private $weight;

    /**
     * @var float|null
     *
     * @ORM\Column(name="count_weight", type="float", precision=10, scale=0, nullable=true, options={"comment"="Общий"})
     */
    private $countWeight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="count", type="integer", nullable=true, options={"comment"="Количество товара"})
     */
    private $count;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price", type="decimal", precision=11, scale=2, nullable=true, options={"comment"="Цена товара"})
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_cancle", type="integer", nullable=true, options={"comment"="Отказной товар"})
     */
    private $isCancle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="v_akt_id", type="integer", nullable=true, options={"comment"="id Акта"})
     */
    private $vAktId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="goods_nds_type", type="integer", nullable=true, options={"comment"="НДС Товара берем из таблицы nds_type"})
     */
    private $goodsNdsType;

    /**
     * @var \GoodsStatusModel
     *
     * @ORM\ManyToOne(targetEntity="GoodsStatusModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="goods_status", referencedColumnName="id")
     * })
     */
    private $goodsStatus;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Goods
     */
    public function setId(int $id): Goods
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getArticle(): ?string
    {
        return $this->article;
    }

    /**
     * @param string|null $article
     * @return Goods
     */
    public function setArticle(?string $article): Goods
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @param string|null $orderId
     * @return Goods
     */
    public function setOrderId(?string $orderId): Goods
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Goods
     */
    public function setDescription(?string $description): Goods
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     * @param float|null $weight
     * @return Goods
     */
    public function setWeight(?float $weight): Goods
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCountWeight(): ?float
    {
        return $this->countWeight;
    }

    /**
     * @param float|null $countWeight
     * @return Goods
     */
    public function setCountWeight(?float $countWeight): Goods
    {
        $this->countWeight = $countWeight;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int|null $count
     * @return Goods
     */
    public function setCount(?int $count): Goods
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     * @return Goods
     */
    public function setPrice(?string $price): Goods
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getisCancle(): ?int
    {
        return $this->isCancle;
    }

    /**
     * @param int|null $isCancle
     * @return Goods
     */
    public function setIsCancle(?int $isCancle): Goods
    {
        $this->isCancle = $isCancle;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVAktId(): ?int
    {
        return $this->vAktId;
    }

    /**
     * @param int|null $vAktId
     * @return Goods
     */
    public function setVAktId(?int $vAktId): Goods
    {
        $this->vAktId = $vAktId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGoodsNdsType(): ?int
    {
        return $this->goodsNdsType;
    }

    /**
     * @param int|null $goodsNdsType
     * @return Goods
     */
    public function setGoodsNdsType(?int $goodsNdsType): Goods
    {
        $this->goodsNdsType = $goodsNdsType;
        return $this;
    }

    /**
     * @return GoodsStatusModel
     */
    public function getGoodsStatus(): GoodsStatusModel
    {
        return $this->goodsStatus;
    }

    /**
     * @param GoodsStatusModel $goodsStatus
     * @return Goods
     */
    public function setGoodsStatus(GoodsStatusModel $goodsStatus): Goods
    {
        $this->goodsStatus = $goodsStatus;
        return $this;
    }

}
