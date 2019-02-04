<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Marks
 *
 * @ORM\Table(name="marks")
 * @ORM\Entity
 */
class Marks
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
     * @var int|null
     *
     * @ORM\Column(name="mark_type", type="integer", nullable=true, options={"comment"="0 - orderperenos, 1- orderotmena, 2 - zorderperenos, 4 - zorderotmena 5- otkaz_na_meste"})
     */
    private $markType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mark_descr", type="string", length=255, nullable=true)
     */
    private $markDescr;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Marks
     */
    public function setId(int $id): Marks
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMarkType(): ?int
    {
        return $this->markType;
    }

    /**
     * @param int|null $markType
     * @return Marks
     */
    public function setMarkType(?int $markType): Marks
    {
        $this->markType = $markType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMarkDescr(): ?string
    {
        return $this->markDescr;
    }

    /**
     * @param string|null $markDescr
     * @return Marks
     */
    public function setMarkDescr(?string $markDescr): Marks
    {
        $this->markDescr = $markDescr;
        return $this;
    }


}
