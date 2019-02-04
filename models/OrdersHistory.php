<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersHistory
 *
 * @ORM\Table(name="orders_history", indexes={@ORM\Index(name="type", columns={"type"}), @ORM\Index(name="oid", columns={"oid"}), @ORM\Index(name="client_id", columns={"client_id"})})
 * @ORM\Entity
 */
class OrdersHistory
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
     * @ORM\Column(name="user_id", type="integer", nullable=true, options={"comment"="автор - наш юзер"})
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="parameter", type="string", length=255, nullable=true, options={"comment"="название параметра"})
     */
    private $parameter;

    /**
     * @var string|null
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true, options={"comment"="новое значеие"})
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP","comment"="Дата/Время"})
     */
    private $datetime = 'CURRENT_TIMESTAMP';

    /**
     * @var \Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="oid", referencedColumnName="id")
     * })
     */
    private $oid;

    /**
     * @var \ClientSettings
     *
     * @ORM\ManyToOne(targetEntity="ClientSettings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="client_id")
     * })
     */
    private $client;

    /**
     * @var \OrdersHistoryTypesModel
     *
     * @ORM\ManyToOne(targetEntity="OrdersHistoryTypesModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;


}
