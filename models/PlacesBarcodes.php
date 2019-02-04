<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PlacesBarcodes
 *
 * @ORM\Table(name="places_barcodes", indexes={@ORM\Index(name="barcode", columns={"barcode"}), @ORM\Index(name="order_id", columns={"oid"})})
 * @ORM\Entity
 */
class PlacesBarcodes
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
     * @ORM\Column(name="place", type="integer", nullable=true)
     */
    private $place;

    /**
     * @var string|null
     *
     * @ORM\Column(name="barcode", type="string", length=255, nullable=true)
     */
    private $barcode;

    /**
     * @var float|null
     *
     * @ORM\Column(name="weight", type="float", precision=9, scale=2, nullable=true)
     */
    private $weight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="reserved", type="integer", nullable=true)
     */
    private $reserved;

    /**
     * @var int|null
     *
     * @ORM\Column(name="first_sklad_scan", type="integer", nullable=true)
     */
    private $firstSkladScan = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="oid", referencedColumnName="id")
     * })
     */
    private $oid;


}
