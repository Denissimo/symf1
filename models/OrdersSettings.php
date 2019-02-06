<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersSettings
 *
 * @ORM\Table(name="orders_settings")
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersSettings
     */
    public function setId(int $id): OrdersSettings
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReciepientName(): ?string
    {
        return $this->reciepientName;
    }

    /**
     * @param string|null $reciepientName
     * @return OrdersSettings
     */
    public function setReciepientName(?string $reciepientName): OrdersSettings
    {
        $this->reciepientName = $reciepientName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDocDescription(): ?string
    {
        return $this->docDescription;
    }

    /**
     * @param string|null $docDescription
     * @return OrdersSettings
     */
    public function setDocDescription(?string $docDescription): OrdersSettings
    {
        $this->docDescription = $docDescription;
        return $this;
    }

}
