<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersStatusModel
 *
 * @ORM\Table(name="zorders_status_model")
 * @ORM\Entity
 */
class ZordersStatusModel
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


}
