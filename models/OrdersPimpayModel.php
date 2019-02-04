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


}
