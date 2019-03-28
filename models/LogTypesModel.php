<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LogTypesModel
 *
 * @ORM\Table(name="log_types_model", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class LogTypesModel extends Model
{

    const
        API_STATUS_V1_ID = 11,
        API_STATUS_V2_ID = 12;
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
     * @ORM\Column(name="type", type="string", length=100, nullable=true, options={"comment"="Description статуса"})
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
     * @return LogTypesModel
     */
    public function setId(int $id): LogTypesModel
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
     * @return LogTypesModel
     */
    public function setType(?string $type): LogTypesModel
    {
        $this->type = $type;
        return $this;
    }


}
