<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * NdsType
 *
 * @ORM\Table(name="nds_type", indexes={@ORM\Index(name="nds", columns={"nds"})})
 * @ORM\Entity
 */
class NdsType
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
     * @var string
     *
     * @ORM\Column(name="nds", type="string", length=100, nullable=false, options={"comment"="Тип НДС"})
     */
    private $nds;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return NdsType
     */
    public function setId(int $id): NdsType
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNds(): string
    {
        return $this->nds;
    }

    /**
     * @param string $nds
     * @return NdsType
     */
    public function setNds(string $nds): NdsType
    {
        $this->nds = $nds;
        return $this;
    }

}
