<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LogsOrders
 *
 * @ORM\Table(name="logs_orders", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="IDX_logs_orders_what", columns={"what"}), @ORM\Index(name="old_id_logs", columns={"old_id_logs"})})
 * @ORM\Entity
 */
class LogsOrders
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
     * @ORM\Column(name="order_id", type="string", length=255, nullable=true, options={"comment"="Номер заказа наш"})
     */
    private $orderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_id", type="string", length=255, nullable=true, options={"comment"="id пользователя - Клиента"})
     */
    private $userId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_create", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP","comment"="Дата создания"})
     */
    private $dateCreate = 'CURRENT_TIMESTAMP';

    /**
     * @var int|null
     *
     * @ORM\Column(name="old_id_logs", type="integer", nullable=true, options={"comment"="Старый id - заказа"})
     */
    private $oldIdLogs;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_logs", type="text", length=0, nullable=true, options={"comment"="Описание"})
     */
    private $descriptionLogs;

    /**
     * @var json|null
     *
     * @ORM\Column(name="json", type="json", nullable=true, options={"comment"="Передача json"})
     */
    private $json;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status_logs", type="string", length=255, nullable=true, options={"comment"="Статусы"})
     */
    private $statusLogs;

    /**
     * @var \LogTypeModel
     *
     * @ORM\ManyToOne(targetEntity="LogTypeModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="what", referencedColumnName="id")
     * })
     */
    private $what;


}
