<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Porders
 *
 * @ORM\Table(name="porders", indexes={@ORM\Index(name="podstatus_id", columns={"podstatus_id"}), @ORM\Index(name="bill_id", columns={"bill_id"}), @ORM\Index(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class Porders
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
     * @ORM\Column(name="order_id", type="string", length=256, nullable=true)
     */
    private $orderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="atar", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $atar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="anp", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $anp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aus", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $aus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bill_id", type="string", length=256, nullable=true)
     */
    private $billId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="enddate", type="date", nullable=true)
     */
    private $enddate;

    /**
     * @var \PordersPodstatusModel
     *
     * @ORM\ManyToOne(targetEntity="PordersPodstatusModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="podstatus_id", referencedColumnName="id")
     * })
     */
    private $podstatus;


}
