<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersSkladsOurModel
 *
 * @ORM\Table(name="zorders_sklads_our_model")
 * @ORM\Entity
 */
class ZordersSkladsOurModel
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
     * @ORM\Column(name="sklad", type="string", length=255, nullable=true)
     */
    private $sklad;


}
