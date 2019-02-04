<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * UsersTokens
 *
 * @ORM\Table(name="users_tokens", indexes={@ORM\Index(name="uiser_id", columns={"uiser_id"})})
 * @ORM\Entity
 */
class UsersTokens
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
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", length=255, nullable=false)
     */
    private $accessToken;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expired_at", type="datetime", nullable=false)
     */
    private $expiredAt;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uiser_id", referencedColumnName="id")
     * })
     */
    private $uiser;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UsersTokens
     */
    public function setId(int $id): UsersTokens
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     * @return UsersTokens
     */
    public function setAccessToken(string $accessToken): UsersTokens
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return UsersTokens
     */
    public function setCreatedAt(?DateTime $createdAt): UsersTokens
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getExpiredAt(): DateTime
    {
        return $this->expiredAt;
    }

    /**
     * @param DateTime $expiredAt
     * @return UsersTokens
     */
    public function setExpiredAt(DateTime $expiredAt): UsersTokens
    {
        $this->expiredAt = $expiredAt;
        return $this;
    }

    /**
     * @return Users
     */
    public function getUiser(): Users
    {
        return $this->uiser;
    }

    /**
     * @param Users $uiser
     * @return UsersTokens
     */
    public function setUiser(Users $uiser): UsersTokens
    {
        $this->uiser = $uiser;
        return $this;
    }

}
