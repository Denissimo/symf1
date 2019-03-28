<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LogResultModel
 *
 * @ORM\Table(name="log_result_model", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class LogResultModel extends Model
{
    const
        HTTP_OK_ID = 8,
        HTTP_BAD_REQUEST_ID = 27,
        HTTP_UNAUTHORIZED_ID = 28,
        HTTP_PAYMENT_REQUIRED_ID = 29,
        HTTP_FORBIDDEN_ID = 30,
        HTTP_NOT_FOUND_ID = 31,
        HTTP_METHOD_NOT_ALLOWED_ID = 32;
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
     * @ORM\Column(name="result", type="string", length=100, nullable=true, options={"comment"="Description результата"})
     */
    private $result;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return LogResultModel
     */
    public function setId(int $id): LogResultModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResult(): ?string
    {
        return $this->result;
    }

    /**
     * @param string|null $result
     * @return LogResultModel
     */
    public function setResult(?string $result): LogResultModel
    {
        $this->result = $result;
        return $this;
    }


}
