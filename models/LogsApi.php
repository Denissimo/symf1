<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LogsApi
 *
 * @ORM\Table(name="logs_api", indexes={@ORM\Index(name="request_type", columns={"request_type"}), @ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="result", columns={"result"})})
 * @ORM\Entity
 */
class LogsApi
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
     * @ORM\Column(name="ip", type="string", length=16, nullable=true, options={"comment"="Вычислить по IP и набить ебало"})
     */
    private $ip;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true, options={"comment"="id юзера"})
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="request", type="text", length=0, nullable=true, options={"comment"="полный текст запроса"})
     */
    private $request;

    /**
     * @var string|null
     *
     * @ORM\Column(name="response", type="text", length=0, nullable=true, options={"comment"="полный текст ответа"})
     */
    private $response;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datetime = 'CURRENT_TIMESTAMP';

    /**
     * @var \ClientSettings
     *
     * @ORM\ManyToOne(targetEntity="ClientSettings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var \LogTypeModel
     *
     * @ORM\ManyToOne(targetEntity="LogTypeModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="request_type", referencedColumnName="id")
     * })
     */
    private $requestType;

    /**
     * @var \LogResultModel
     *
     * @ORM\ManyToOne(targetEntity="LogResultModel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="result", referencedColumnName="id")
     * })
     */
    private $result;


}
