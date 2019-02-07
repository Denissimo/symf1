<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * GoodsStatusModel
 *
 * @ORM\Table(name="goods_status_model", uniqueConstraints={@ORM\UniqueConstraint(name="UK_goods_status_model_id", columns={"id"})}, indexes={@ORM\Index(name="goods_status", columns={"goods_status"})})
 * @ORM\Entity
 */
class GoodsStatusModel
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
     * @ORM\Column(name="goods_status", type="string", length=100, nullable=true, options={"comment"="Description статуса"})
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
     * @return GoodsStatusModel
     */
    public function setId(int $id): GoodsStatusModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGoodsStatus(): ?string
    {
        return $this->goodsStatus;
    }

    /**
     * @param string|null $goodsStatus
     * @return GoodsStatusModel
     */
    public function setGoodsStatus(?string $goodsStatus): GoodsStatusModel
    {
        $this->goodsStatus = $goodsStatus;
        return $this;
    }
}
