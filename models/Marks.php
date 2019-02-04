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


}
