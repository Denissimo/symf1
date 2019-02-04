<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AddressTypesModel
 *
 * @ORM\Table(name="address_types_model", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class AddressTypesModel
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
     * @ORM\Column(name="type", type="string", length=100, nullable=true, options={"comment"="type description"})
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
     * @return AddressTypesModel
     */
    public function setId(int $id): AddressTypesModel
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
     * @return AddressTypesModel
     */
    public function setType(?string $type): AddressTypesModel
    {
        $this->type = $type;
        return $this;
    }


}
