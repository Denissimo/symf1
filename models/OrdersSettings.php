<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersSettings
 *
 * @ORM\Table(name="orders_settings")
 * @ORM\Entity
 */
class OrdersSettings
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
     * @ORM\Column(name="reciepient_name", type="string", length=256, nullable=true, options={"comment"="Фактический получатель"})
     */
    private $reciepientName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="doc_description", type="string", length=256, nullable=true, options={"comment"="Ооо или ип"})
     */
    private $docDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="is_packed", type="string", length=256, nullable=true, options={"comment"="Флажок упаковки"})
     */
    private $isPacked;

    /**
     * @var string|null
     *
     * @ORM\Column(name="np", type="string", length=256, nullable=true, options={"comment"="Флажок НП"})
     */
    private $np;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sms", type="string", length=256, nullable=true, options={"comment"="SMS"})
     */
    private $sms;

    /**
     * @var string|null
     *
     * @ORM\Column(name="is_complect", type="string", length=256, nullable=true, options={"comment"="Флажок комплектации"})
     */
    private $isComplect;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agent_act", type="string", length=256, nullable=true)
     */
    private $agentAct;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agent_vact", type="string", length=256, nullable=true)
     */
    private $agentVact;

    /**
     * @var int|null
     *
     * @ORM\Column(name="isoh", type="integer", nullable=true)
     */
    private $isoh;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ordercall", type="integer", nullable=true, options={"comment"="опция хз"})
     */
    private $ordercall;

    /**
     * @var int|null
     *
     * @ORM\Column(name="chweightflag", type="integer", nullable=true, options={"comment"="опция Максипост"})
     */
    private $chweightflag;

    /**
     * @var string|null
     *
     * @ORM\Column(name="partner_act", type="string", length=256, nullable=true, options={"comment"="reserved"})
     */
    private $partnerAct;

    /**
     * @var int|null
     *
     * @ORM\Column(name="open_option", type="integer", nullable=true, options={"default"="1","comment"="Вскрытие"})
     */
    private $openOption = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="call_option", type="integer", nullable=true, options={"comment"="Предварительный прозвон"})
     */
    private $callOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="label_option", type="integer", nullable=true, options={"comment"="этикирование"})
     */
    private $labelOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="docs_option", type="integer", nullable=true, options={"comment"="Вложение накладной"})
     */
    private $docsOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="docs_return_option", type="integer", nullable=true, options={"comment"="Возврат накладной"})
     */
    private $docsReturnOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="partial_option", type="integer", nullable=true, options={"default"="1","comment"="Ч.о."})
     */
    private $partialOption = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="dress_fitting_option", type="integer", nullable=true, options={"comment"="примерка"})
     */
    private $dressFittingOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="lifting_option", type="integer", nullable=true, options={"comment"="подъем"})
     */
    private $liftingOption;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cargo_lift", type="integer", nullable=true, options={"comment"="наличие лифта"})
     */
    private $cargoLift;

    /**
     * @var int|null
     *
     * @ORM\Column(name="change_option", type="integer", nullable=true, options={"comment"="обмен"})
     */
    private $changeOption;

    /**
     * @var string|null
     *
     * @ORM\Column(name="change_text", type="text", length=0, nullable=true, options={"comment"="текст обмена"})
     */
    private $changeText;

    /**
     * @var float|null
     *
     * @ORM\Column(name="dimension_side1", type="float", precision=10, scale=0, nullable=true, options={"default"="10","comment"="Габарит 1"})
     */
    private $dimensionSide1 = '10';

    /**
     * @var float|null
     *
     * @ORM\Column(name="dimension_side2", type="float", precision=10, scale=0, nullable=true, options={"default"="10","comment"="Габарит 2"})
     */
    private $dimensionSide2 = '10';

    /**
     * @var float|null
     *
     * @ORM\Column(name="dimension_side3", type="float", precision=10, scale=0, nullable=true, options={"default"="10","comment"="Габарит 3"})
     */
    private $dimensionSide3 = '10';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_dop_compl", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Комплектация, руб"})
     */
    private $pdDopCompl = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_call", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Прозвон, руб"})
     */
    private $pdCall = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_sms", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="смс, руб"})
     */
    private $pdSms = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_label", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="этикирование, руб"})
     */
    private $pdLabel = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_docs", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="вложение накл., руб"})
     */
    private $pdDocs = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_docs_return", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="возврат док., руб"})
     */
    private $pdDocsReturn = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_change", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="обмен, руб"})
     */
    private $pdChange = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_dop_pack", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Упаковка, руб"})
     */
    private $pdDopPack = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="pd_dop_vozvrat", type="decimal", precision=9, scale=2, nullable=true, options={"default"="0.00","comment"="Обработка возврата, руб"})
     */
    private $pdDopVozvrat = '0.00';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrdersSettings
     */
    public function setId(int $id): OrdersSettings
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReciepientName(): ?string
    {
        return $this->reciepientName;
    }

    /**
     * @param string|null $reciepientName
     * @return OrdersSettings
     */
    public function setReciepientName(?string $reciepientName): OrdersSettings
    {
        $this->reciepientName = $reciepientName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDocDescription(): ?string
    {
        return $this->docDescription;
    }

    /**
     * @param string|null $docDescription
     * @return OrdersSettings
     */
    public function setDocDescription(?string $docDescription): OrdersSettings
    {
        $this->docDescription = $docDescription;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsPacked(): ?string
    {
        return $this->isPacked;
    }

    /**
     * @param string|null $isPacked
     * @return OrdersSettings
     */
    public function setIsPacked(?string $isPacked): OrdersSettings
    {
        $this->isPacked = $isPacked;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNp(): ?string
    {
        return $this->np;
    }

    /**
     * @param string|null $np
     * @return OrdersSettings
     */
    public function setNp(?string $np): OrdersSettings
    {
        $this->np = $np;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSms(): ?string
    {
        return $this->sms;
    }

    /**
     * @param string|null $sms
     * @return OrdersSettings
     */
    public function setSms(?string $sms): OrdersSettings
    {
        $this->sms = $sms;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsComplect(): ?string
    {
        return $this->isComplect;
    }

    /**
     * @param string|null $isComplect
     * @return OrdersSettings
     */
    public function setIsComplect(?string $isComplect): OrdersSettings
    {
        $this->isComplect = $isComplect;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAgentAct(): ?string
    {
        return $this->agentAct;
    }

    /**
     * @param string|null $agentAct
     * @return OrdersSettings
     */
    public function setAgentAct(?string $agentAct): OrdersSettings
    {
        $this->agentAct = $agentAct;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAgentVact(): ?string
    {
        return $this->agentVact;
    }

    /**
     * @param string|null $agentVact
     * @return OrdersSettings
     */
    public function setAgentVact(?string $agentVact): OrdersSettings
    {
        $this->agentVact = $agentVact;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIsoh(): ?int
    {
        return $this->isoh;
    }

    /**
     * @param int|null $isoh
     * @return OrdersSettings
     */
    public function setIsoh(?int $isoh): OrdersSettings
    {
        $this->isoh = $isoh;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrdercall(): ?int
    {
        return $this->ordercall;
    }

    /**
     * @param int|null $ordercall
     * @return OrdersSettings
     */
    public function setOrdercall(?int $ordercall): OrdersSettings
    {
        $this->ordercall = $ordercall;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getChweightflag(): ?int
    {
        return $this->chweightflag;
    }

    /**
     * @param int|null $chweightflag
     * @return OrdersSettings
     */
    public function setChweightflag(?int $chweightflag): OrdersSettings
    {
        $this->chweightflag = $chweightflag;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartnerAct(): ?string
    {
        return $this->partnerAct;
    }

    /**
     * @param string|null $partnerAct
     * @return OrdersSettings
     */
    public function setPartnerAct(?string $partnerAct): OrdersSettings
    {
        $this->partnerAct = $partnerAct;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOpenOption(): ?int
    {
        return $this->openOption;
    }

    /**
     * @param int|null $openOption
     * @return OrdersSettings
     */
    public function setOpenOption(?int $openOption): OrdersSettings
    {
        $this->openOption = $openOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCallOption(): ?int
    {
        return $this->callOption;
    }

    /**
     * @param int|null $callOption
     * @return OrdersSettings
     */
    public function setCallOption(?int $callOption): OrdersSettings
    {
        $this->callOption = $callOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLabelOption(): ?int
    {
        return $this->labelOption;
    }

    /**
     * @param int|null $labelOption
     * @return OrdersSettings
     */
    public function setLabelOption(?int $labelOption): OrdersSettings
    {
        $this->labelOption = $labelOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDocsOption(): ?int
    {
        return $this->docsOption;
    }

    /**
     * @param int|null $docsOption
     * @return OrdersSettings
     */
    public function setDocsOption(?int $docsOption): OrdersSettings
    {
        $this->docsOption = $docsOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDocsReturnOption(): ?int
    {
        return $this->docsReturnOption;
    }

    /**
     * @param int|null $docsReturnOption
     * @return OrdersSettings
     */
    public function setDocsReturnOption(?int $docsReturnOption): OrdersSettings
    {
        $this->docsReturnOption = $docsReturnOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPartialOption(): ?int
    {
        return $this->partialOption;
    }

    /**
     * @param int|null $partialOption
     * @return OrdersSettings
     */
    public function setPartialOption(?int $partialOption): OrdersSettings
    {
        $this->partialOption = $partialOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDressFittingOption(): ?int
    {
        return $this->dressFittingOption;
    }

    /**
     * @param int|null $dressFittingOption
     * @return OrdersSettings
     */
    public function setDressFittingOption(?int $dressFittingOption): OrdersSettings
    {
        $this->dressFittingOption = $dressFittingOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLiftingOption(): ?int
    {
        return $this->liftingOption;
    }

    /**
     * @param int|null $liftingOption
     * @return OrdersSettings
     */
    public function setLiftingOption(?int $liftingOption): OrdersSettings
    {
        $this->liftingOption = $liftingOption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCargoLift(): ?int
    {
        return $this->cargoLift;
    }

    /**
     * @param int|null $cargoLift
     * @return OrdersSettings
     */
    public function setCargoLift(?int $cargoLift): OrdersSettings
    {
        $this->cargoLift = $cargoLift;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getChangeOption(): ?int
    {
        return $this->changeOption;
    }

    /**
     * @param int|null $changeOption
     * @return OrdersSettings
     */
    public function setChangeOption(?int $changeOption): OrdersSettings
    {
        $this->changeOption = $changeOption;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChangeText(): ?string
    {
        return $this->changeText;
    }

    /**
     * @param string|null $changeText
     * @return OrdersSettings
     */
    public function setChangeText(?string $changeText): OrdersSettings
    {
        $this->changeText = $changeText;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getDimensionSide1(): ?float
    {
        return $this->dimensionSide1;
    }

    /**
     * @param float|null $dimensionSide1
     * @return OrdersSettings
     */
    public function setDimensionSide1(?float $dimensionSide1): OrdersSettings
    {
        $this->dimensionSide1 = $dimensionSide1;
        return $this;
    }

}
