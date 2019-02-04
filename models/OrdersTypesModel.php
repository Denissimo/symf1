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


}
