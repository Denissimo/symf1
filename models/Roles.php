<?php



use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\Collection;
use \Doctrine\Common\Collections\ArrayCollection;


/**
 * Roles
 *
 * @ORM\Table(name="roles", indexes={@ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Roles
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
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="role")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new ArrayCollection();
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
     * @return Roles
     */
    public function setId(int $id): Roles
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
     * @return Roles
     */
    public function setName(string $name): Roles
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Roles
     */
    public function setDescription(?string $description): Roles
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    /**
     * @param Collection $user
     * @return Roles
     */
    public function setUser(Collection $user): Roles
    {
        $this->user = $user;
        return $this;
    }
}
