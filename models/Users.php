<?php


use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1483A5E9E7927C74", columns={"email"})}, indexes={@ORM\Index(name="enabled", columns={"enabled"})})
 * @ORM\Entity
 */
class Users implements UserInterface
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="user_pic", type="string", length=255, nullable=false)
     */
    private $userPic;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Roles", inversedBy="user")
     * @ORM\JoinTable(name="users_roles",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     *   }
     * )
     */
    private $role;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Users
     */
    public function setId(int $id): Users
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Users
     */
    public function setName(string $name): Users
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Users
     */
    public function setEmail(string $email): Users
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Users
     */
    public function setPassword(string $password): Users
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return Users
     */
    public function setEnabled(bool $enabled): Users
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPic(): string
    {
        return $this->userPic;
    }

    /**
     * @param string $userPic
     * @return Users
     */
    public function setUserPic(string $userPic): Users
    {
        $this->userPic = $userPic;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole(): \Doctrine\Common\Collections\Collection
    {
        return $this->role;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $role
     * @return Users
     */
    public function setRole(\Doctrine\Common\Collections\Collection $role): Users
    {
        $this->role = $role;
        return $this;
    }

    /**
     * массив ролей
     *
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'/* @todo, $this->getRole() */];
    }

    /**
     * Соль для пароля
     *
     * @return string|null
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * Имя пользователя
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getName();
    }

    public function eraseCredentials()
    {

    }
}
