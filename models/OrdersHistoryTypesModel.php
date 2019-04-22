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

    const
        CREATE_ID = 1,
        IMPORT_ID = 3,
        UPDATE_ID = 4;
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersHistoryTypesModel
     */
    public function setId(int $id): OrdersHistoryTypesModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return OrdersHistoryTypesModel
     */
    public function setType(?string $type): OrdersHistoryTypesModel
    {
        $this->type = $type;
        return $this;
    }

}
