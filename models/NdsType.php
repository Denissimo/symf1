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


}
