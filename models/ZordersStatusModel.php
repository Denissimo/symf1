<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersStatusModel
 *
 * @ORM\Table(name="zorders_status_model")
 * @ORM\Entity
 */
class ZordersStatusModel extends Model
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
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
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
     * @return ZordersStatusModel
     */
    public function setId(int $id): ZordersStatusModel
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
     * @return ZordersStatusModel
     */
    public function setStatus(?string $status): ZordersStatusModel
    {
        $this->status = $status;
        return $this;
    }
}
