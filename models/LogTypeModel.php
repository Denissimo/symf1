<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LogTypeModel
 *
 * @ORM\Table(name="log_type_model", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class LogTypeModel
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
     * @return LogTypeModel
     */
    public function setId(int $id): LogTypeModel
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
     * @return LogTypeModel
     */
    public function setType(?string $type): LogTypeModel
    {
        $this->type = $type;
        return $this;
    }


}
