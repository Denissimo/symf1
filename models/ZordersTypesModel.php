<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersTypesModel
 *
 * @ORM\Table(name="zorders_types_model")
 * @ORM\Entity
 */
class ZordersTypesModel extends Model
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
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
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
     * @return ZordersTypesModel
     */
    public function setId(int $id): ZordersTypesModel
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
     * @return ZordersTypesModel
     */
    public function setType(?string $type): ZordersTypesModel
    {
        $this->type = $type;
        return $this;
    }

}
