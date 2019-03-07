<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Goods
 *
 * @ORM\Table(name="goods", indexes={@ORM\Index(name="goods_nds_type", columns={"goods_nds_type"}), @ORM\Index(name="order_id", columns={"order_id"}), @ORM\Index(name="FK_goods_goods_status", columns={"goods_status"})})
 * @ORM\Entity
 */
class Goods
{
    const
        ORDERID = 'orderId',
        ID = 'id'
    ;
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
     * @var string|null
     *
     * @ORM\Column(name="article", type="string", length=256, nullable=true, options={"comment"="Бывший articul - Артикул клиента (заказа)"})
     */
    private $article;

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
     * @ORM\Column(name="is_cancel", type="integer", nullable=true, options={"comment"="Отказной товар"})
     */
    private $isCancel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_akt_id", type="string", nullable=true, options={"comment"="id Акта"})
     */
    private $vAktId;

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
     * @var \NdsType | null
     *
     * @ORM\ManyToOne(targetEntity="NdsType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="goods_nds_type", referencedColumnName="id")
     * })
     */
    private $goodsNdsType;

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
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     */
    private $orderId;


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
    public function getIsCancel(): ?int
    {
        return $this->isCancel;
    }

    /**
     * @param int|null $isCancel
     * @return Goods
     */
    public function setIsCancel(?int $isCancel): Goods
    {
        $this->isCancel = $isCancel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVAktId()
    {
        return $this->vAktId;
    }

    /**
     * @param string | null $vAktId
     * @return Goods
     */
    public function setVAktId($vAktId): Goods
    {
        $this->vAktId = $vAktId;
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

    /**
     * @return NdsType
     */
    public function getGoodsNdsType(): NdsType
    {
        return $this->goodsNdsType;
    }

    /**
     * @param NdsType $goodsNdsType | null
     * @return Goods
     */
    public function setGoodsNdsType($goodsNdsType): Goods
    {
        $this->goodsNdsType = $goodsNdsType;
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
     * @return Goods
     */
    public function setOrder(Orders $order): Goods
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     * @return Goods
     */
    public function setOrderId(int $orderId): Goods
    {
        $this->orderId = $orderId;
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
     * @return Goods
     */
    public function setOldId(?int $oldId): Goods
    {
        $this->oldId = $oldId;
        return $this;
    }
}
