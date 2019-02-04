<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PordersPodstatusModel
 *
 * @ORM\Table(name="porders_podstatus_model")
 * @ORM\Entity
 */
class PordersPodstatusModel
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
     * @ORM\Column(name="podstatus", type="string", length=255, nullable=true)
     */
    private $podstatus;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PordersPodstatusModel
     */
    public function setId(int $id): PordersPodstatusModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPodstatus(): ?string
    {
        return $this->podstatus;
    }

    /**
     * @param string|null $podstatus
     * @return PordersPodstatusModel
     */
    public function setPodstatus(?string $podstatus): PordersPodstatusModel
    {
        $this->podstatus = $podstatus;
        return $this;
    }


}
