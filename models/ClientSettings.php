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


}
