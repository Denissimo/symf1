<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersHistoryTypesModel
 *
 * @ORM\Table(name="orders_history_types_model", uniqueConstraints={@ORM\UniqueConstraint(name="UK_order_status_model_id", columns={"id"})})
 * @ORM\Entity
 */
class OrdersHistoryTypesModel
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
     * @ORM\Column(name="type", type="string", length=100, nullable=true, options={"comment"="Тип - описание"})
     */
    private $type;


}
