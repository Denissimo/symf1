<?php


use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersStatusModel
 *
 * @ORM\Table(name="orders_status_model", uniqueConstraints={@ORM\UniqueConstraint(name="UK_order_status_model_id", columns={"id"})})
 * @ORM\Entity
 */
class OrdersStatusModel
{

    const
        STATUS_PARTIAL_FAILURE = 6, // Частичный отказ
        STATUS_REJECTION = 7, // полный отказ
        STATUS_CANCEL = 8; // отмена

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
     * @ORM\Column(name="status", type="string", length=100, nullable=true, options={"comment"="Description статуса"})
     */
    private $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersStatusModel
     */
    public function setId(int $id): OrdersStatusModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return OrdersStatusModel
     */
    public function setStatus(?string $status): OrdersStatusModel
    {
        $this->status = $status;
        return $this;
    }

}
