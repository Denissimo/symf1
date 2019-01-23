<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Goods
 *
 * @ORM\Table(name="goods", indexes={@ORM\Index(name="order_id", columns={"order_id"}), @ORM\Index(name="FK_goods_goods_status", columns={"goods_status"}), @ORM\Index(name="goods_nds_type", columns={"goods_nds_type"})})
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


}
