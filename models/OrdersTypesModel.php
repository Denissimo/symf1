<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersTypesModel
 *
 * @ORM\Table(name="orders_types_model", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class OrdersTypesModel
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
     * @ORM\Column(name="type", type="string", length=100, nullable=true, options={"comment"="Описание типа"})
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
     * @return OrdersTypesModel
     */
    public function setId(int $id): OrdersTypesModel
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
     * @return OrdersTypesModel
     */
    public function setType(?string $type): OrdersTypesModel
    {
        $this->type = $type;
        return $this;
    }

}
