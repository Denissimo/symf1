<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ClientSettings
 *
 * @ORM\Table(name="client_settings", uniqueConstraints={@ORM\UniqueConstraint(name="client_id", columns={"client_id"})})
 * @ORM\Entity
 */
class ClientSettings
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
     * @ORM\Column(name="client_id", type="integer", nullable=true)
     */
    private $clientId;

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


}
