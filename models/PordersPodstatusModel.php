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


}
