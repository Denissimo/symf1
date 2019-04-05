<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersVaktPartStatusModel
 *
 * @ORM\Table(name="zorders_vakt_part_status_model")
 * @ORM\Entity
 */
class ZordersVaktPartStatusModel extends Model
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
     * @return ZordersVaktPartStatusModel
     */
    public function setId(int $id): ZordersVaktPartStatusModel
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
     * @return ZordersVaktPartStatusModel
     */
    public function setStatus(?string $status): ZordersVaktPartStatusModel
    {
        $this->status = $status;
        return $this;
    }


}
