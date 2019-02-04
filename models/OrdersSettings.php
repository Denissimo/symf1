<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersSettings
 *
 * @ORM\Table(name="orders_settings", uniqueConstraints={@ORM\UniqueConstraint(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class OrdersSettings
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
     * @ORM\Column(name="reciepient_name", type="string", length=256, nullable=true, options={"comment"="Фактический получатель"})
     */
    private $reciepientName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="doc_description", type="string", length=256, nullable=true, options={"comment"="Ооо или ип"})
     */
    private $docDescription;

    /**
     * @var \Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;


}
