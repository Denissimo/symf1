<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PlacesBarcodesStatusModel
 *
 * @ORM\Table(name="places_barcodes_status_model")
 * @ORM\Entity
 */
class PlacesBarcodesStatusModel
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
     * @return PlacesBarcodesStatusModel
     */
    public function setId(int $id): PlacesBarcodesStatusModel
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
     * @return PlacesBarcodesStatusModel
     */
    public function setStatus(?string $status): PlacesBarcodesStatusModel
    {
        $this->status = $status;
        return $this;
    }

}
