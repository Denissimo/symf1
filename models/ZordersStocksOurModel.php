<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ZordersStocksOurModel
 *
 * @ORM\Table(name="zorders_stocks_our_model")
 * @ORM\Entity
 */
class ZordersStocksOurModel
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
     * @ORM\Column(name="sklad", type="string", length=255, nullable=true)
     */
    private $sklad;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ZordersStocksOurModel
     */
    public function setId(int $id): ZordersStocksOurModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSklad(): ?string
    {
        return $this->sklad;
    }

    /**
     * @param string|null $sklad
     * @return ZordersStocksOurModel
     */
    public function setSklad(?string $sklad): ZordersStocksOurModel
    {
        $this->sklad = $sklad;
        return $this;
    }

}
