<?php


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * ClientSettings
 *
 * @ORM\Table(name="client_settings", uniqueConstraints={@ORM\UniqueConstraint(name="client_id", columns={"client_id"})})
 * @ORM\Entity
 */
class ClientSettings extends Model
{
    const
        CLIENTID = 'clientId',
        CLIENT_ID = 'client_id',
        API_KEY = 'apikey',
        IS_OFF = 'is_off',
        ACTIVE = 'active';

    const
        VALUE_ACTIVE = 1;


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
     * @ORM\Column(name="client_id", type="integer", nullable=true)
     */
    private $clientId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_off", type="integer", nullable=true)
     */
    private $isOff;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apikey", type="string", length=111, nullable=true, options={"comment"="API key"})
     */
    private $apikey;

    /**
     * @var int|null
     *
     * @ORM\Column(name="active", type="integer", nullable=true)
     */
    private $active;

    //     * @ORM\OrderBy({"id" = "DESC"})

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="\Orders", mappedBy="client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="client_id", nullable=true)
     * })
     */
    private $orders;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ClientSettings
     */
    public function setId(int $id): ClientSettings
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    /**
     * @param int|null $clientId
     * @return ClientSettings
     */
    public function setClientId(?int $clientId): ClientSettings
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getisOff(): ?int
    {
        return $this->isOff;
    }

    /**
     * @param int|null $isOff
     * @return ClientSettings
     */
    public function setIsOff(?int $isOff): ClientSettings
    {
        $this->isOff = $isOff;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getApikey(): ?string
    {
        return $this->apikey;
    }

    /**
     * @param string|null $apikey
     * @return ClientSettings
     */
    public function setApikey(?string $apikey): ClientSettings
    {
        $this->apikey = $apikey;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getActive(): ?int
    {
        return $this->active;
    }

    /**
     * @param int|null $active
     * @return ClientSettings
     */
    public function setActive(?int $active): ClientSettings
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * @param Collection $orders
     * @return ClientSettings
     */
    public function setOrders(Collection $orders): ClientSettings
    {
        $this->orders = $orders;
        return $this;
    }

}
