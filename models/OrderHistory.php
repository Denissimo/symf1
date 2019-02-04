<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrderHistory
 *
 * @ORM\Table(name="order_history", indexes={@ORM\Index(name="old_id_logs", columns={"description"}), @ORM\Index(name="IDX_logs_orders_what", columns={"what"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class OrderHistory
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
     * @var int|null
     *
     * @ORM\Column(name="what", type="integer", nullable=true)
     */
    private $what;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_id", type="string", length=255, nullable=true, options={"comment"="id пользователя - Клиента"})
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true, options={"comment"="Старый id - заказа"})
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="old_value", type="text", length=0, nullable=true, options={"comment"="Описание"})
     */
    private $oldValue;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="time", type="time", nullable=true, options={"comment"="Дата создания"})
     */
    private $time;


}
