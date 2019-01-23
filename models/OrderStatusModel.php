<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrderStatusModel
 *
 * @ORM\Table(name="order_status_model", uniqueConstraints={@ORM\UniqueConstraint(name="UK_order_status_model_id", columns={"id"})})
 * @ORM\Entity
 */
class OrderStatusModel
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
     * @ORM\Column(name="status", type="string", length=100, nullable=true, options={"comment"="Description статуса"})
     */
    private $status;


}
