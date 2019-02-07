<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersPimpayModel
 *
 * @ORM\Table(name="orders_pimpay_model", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class OrdersPimpayModel
{
    const
        DEFAULT_ID = 1;
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
     * @ORM\Column(name="pimpay", type="string", length=100, nullable=true, options={"comment"="pimpay статус"})
     */
    private $pimpay;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersPimpayModel
     */
    public function setId(int $id): OrdersPimpayModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPimpay(): ?string
    {
        return $this->pimpay;
    }

    /**
     * @param string|null $pimpay
     * @return OrdersPimpayModel
     */
    public function setPimpay(?string $pimpay): OrdersPimpayModel
    {
        $this->pimpay = $pimpay;
        return $this;
    }


}
