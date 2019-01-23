<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="FK_orders_status", columns={"status"}), @ORM\Index(name="oid", columns={"old_id"}), @ORM\Index(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class Orders
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment"="AI"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="old_id", type="integer", nullable=true, options={"comment"="Старый id из древней БД"})
     */
    private $oldId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="order_id", type="string", length=255, nullable=true, options={"comment"="Наш внутренний номер"})
     */
    private $orderId;

    /**
     * @var \OrderStatusModel
     *
     * @ORM\ManyToOne(targetEntity="OrderStatusModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status", referencedColumnName="id")
     * })
     */
    private $status;


}
