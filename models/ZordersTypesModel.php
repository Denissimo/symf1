<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersTypesModel
 *
 * @ORM\Table(name="zorders_types_model")
 * @ORM\Entity
 */
class ZordersTypesModel
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
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;


}
