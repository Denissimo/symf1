<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 *
 * @ORM\Table(name="options", uniqueConstraints={@ORM\UniqueConstraint(name="options_name", columns={"name"})})
 * @ORM\Entity
 */
class Options
{
    const
        NAME = 'name',
        VALUE = 'value'
    ;

    CONST
        UPDATE = 'update',
        LAST_ID = 'last_id',
        USE_ID = 'use_id',
        ORDERS_UPDATE = 'orders_update_last_datetime',
        ORDERS_LAST_ID = 'orders_update_last_order_id',
        ORDERS_USE_ID = 'orders_update_use_order_id',
        PORDERS_UPDATE = 'porders_update_last_datetime',
        PORDERS_LAST_ID = 'porders_update_last_porder_id',
        PORDERS_USE_ID = 'porders_update_use_porder_id',
        ZORDERS_UPDATE = 'zorders_update_last_datetime',
        ZORDERS_LAST_ID = 'zorders_update_last_zorder_id',
        ZORDERS_USE_ID = 'zorders_update_use_zorder_id',
        FORMAT = 'Y-m-d H:i:s'
    ;

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
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Options
     */
    public function setId(int $id): Options
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Options
     */
    public function setName(?string $name): Options
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return Options
     */
    public function setValue(?string $value): Options
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool|DateTime
     */
    public function getUpdateLastDatetime()
    {
        return DateTime::createFromFormat(self::FORMAT, $this->value);
    }

    /**
     * @param DateTime $value
     * @return $this
     */
    public function setUpdateLastDatetime(\DateTime $value)
    {
        $this->value = $value->format(self::FORMAT);
        return $this;
    }


    /**
     * @return int
     */
    public function getOrdersUpdateLastId()
    {
        return (int)$this->value;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setOrdersUpdateLastId(int $id)
    {
        $this->value = $id;
        return $this;
    }

    public static function fields()
    {
        return [
            \Orders::class => [
                self::UPDATE => self::ORDERS_UPDATE,
                self::LAST_ID => self::ORDERS_LAST_ID,
                self::USE_ID => self::ORDERS_USE_ID
            ],
            'Control' => [
                self::UPDATE => 'control_update_last_datetime',
                self::LAST_ID => 'control_update_last_order_id',
                self::USE_ID => 'control_update_use_order_id'
            ],
            \Porders::class => [
                self::UPDATE => self::PORDERS_UPDATE,
                self::LAST_ID => self::PORDERS_LAST_ID,
                self::USE_ID => self::PORDERS_USE_ID
            ],
            \Zorders::class => [
                self::UPDATE => self::ZORDERS_UPDATE,
                self::LAST_ID => self::ZORDERS_LAST_ID,
                self::USE_ID => self::ZORDERS_USE_ID
            ]
        ];
    }

}
