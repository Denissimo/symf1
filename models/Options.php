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
        ORDERS_UPDATE = 'orders_update_last_datetime',
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
    public function getOrdersUpdateLastDatetime()
    {
        return DateTime::createFromFormat(self::FORMAT, $this->value);
    }

    /**
     * @param DateTime $value
     * @return $this
     */
    public function setOrdersUpdateLastDatetime(\DateTime $value)
    {
        $this->value = $value->format(self::FORMAT);
        return $this;
    }
}
