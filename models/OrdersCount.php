<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersCount
 *
 * @ORM\Table(name="orders_count")
 * @ORM\Entity
 */
class OrdersCount
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
     * @var int|null
     *
     * @ORM\Column(name="client_id", type="integer", nullable=true)
     */
    private $clientId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="orders_qty", type="integer", nullable=true)
     */
    private $ordersQty;

    /**
     * @var int|null
     *
     * @ORM\Column(name="last_id", type="integer", nullable=true)
     */
    private $lastId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersCount
     */
    public function setId(int $id): OrdersCount
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    /**
     * @param int|null $clientId
     * @return OrdersCount
     */
    public function setClientId(?int $clientId): OrdersCount
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrdersQty(): ?int
    {
        return $this->ordersQty;
    }

    /**
     * @param int|null $ordersQty
     * @return OrdersCount
     */
    public function setOrdersQty(?int $ordersQty): OrdersCount
    {
        $this->ordersQty = $ordersQty;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLastId(): ?int
    {
        return $this->lastId;
    }

    /**
     * @param int|null $lastId
     * @return OrdersCount
     */
    public function setLastId(?int $lastId): OrdersCount
    {
        $this->lastId = $lastId;
        return $this;
    }


}
