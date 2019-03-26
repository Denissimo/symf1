<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersPvz
 *
 * @ORM\Table(name="orders_pvz", indexes={@ORM\Index(name="IDX_orders_pvz_order_id", columns={"order_id"}), @ORM\Index(name="IDX_orders_pvz_pvz_id", columns={"pvz_id"})})
 * @ORM\Entity
 */
class OrdersPvz
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
     * @ORM\Column(name="order_id_txt", type="string", length=255, nullable=true)
     */
    private $orderIdTxt;

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
     * @var \Pvz
     *
     * @ORM\ManyToOne(targetEntity="Pvz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pvz_id", referencedColumnName="id")
     * })
     */
    private $pvz;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersPvz
     */
    public function setId(int $id): OrdersPvz
    {
        $this->id = $id;
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
     * @return OrdersPvz
     */
    public function setOrder(Orders $order): OrdersPvz
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Pvz
     */
    public function getPvz(): Pvz
    {
        return $this->pvz;
    }

    /**
     * @param Pvz $pvz
     * @return OrdersPvz
     */
    public function setPvz(Pvz $pvz): OrdersPvz
    {
        $this->pvz = $pvz;
        return $this;
    }

}
