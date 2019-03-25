<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Pvz
 *
 * @ORM\Table(name="pvz", indexes={@ORM\Index(name="mxm_id", columns={"mxm_id"}), @ORM\Index(name="mo_punkt_id", columns={"mo_punkt_id"}), @ORM\Index(name="pagent_id", columns={"pagent_id"})})
 * @ORM\Entity
 */
class Pvz
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
     * @ORM\Column(name="mxm_id", type="integer", nullable=true)
     */
    private $mxmId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=256, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=256, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_name", type="string", length=256, nullable=true)
     */
    private $contactName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_number", type="string", length=256, nullable=true)
     */
    private $contactNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_mail", type="string", length=256, nullable=true)
     */
    private $contactMail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dognum", type="string", length=256, nullable=true)
     */
    private $dognum;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dogdate", type="string", length=256, nullable=true)
     */
    private $dogdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pathDesc", type="text", length=0, nullable=true)
     */
    private $pathdesc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="workTime", type="string", length=256, nullable=true)
     */
    private $worktime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="workTime2", type="string", length=256, nullable=true)
     */
    private $worktime2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addrFull", type="string", length=256, nullable=true)
     */
    private $addrfull;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addrStreet", type="string", length=256, nullable=true)
     */
    private $addrstreet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addrHouse", type="string", length=256, nullable=true)
     */
    private $addrhouse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="coords", type="string", length=256, nullable=true)
     */
    private $coords;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deliveryCost", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $deliverycost;

    /**
     * @var string|null
     *
     * @ORM\Column(name="route", type="string", length=256, nullable=true)
     */
    private $route;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mo_punkt_id", type="string", length=256, nullable=true)
     */
    private $moPunktId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pvz_type", type="integer", nullable=true)
     */
    private $pvzType;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pvz_tar", type="integer", nullable=true)
     */
    private $pvzTar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pagent_id", type="integer", nullable=true)
     */
    private $pagentId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="internal", type="integer", nullable=true)
     */
    private $internal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="np", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $np;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tar", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $tar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="weight", type="integer", nullable=true)
     */
    private $weight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true, options={"default"="1"})
     */
    private $status = '1';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="chdate", type="datetime", nullable=true)
     */
    private $chdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="string", length=256, nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment2", type="string", length=256, nullable=true)
     */
    private $comment2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postal_code", type="string", length=256, nullable=true)
     */
    private $postalCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region_with_type", type="string", length=256, nullable=true)
     */
    private $regionWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="area_with_type", type="string", length=256, nullable=true)
     */
    private $areaWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city_with_type", type="string", length=256, nullable=true)
     */
    private $cityWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city_district_with_type", type="string", length=256, nullable=true)
     */
    private $cityDistrictWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="settlement_with_type", type="string", length=256, nullable=true)
     */
    private $settlementWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street_with_type", type="string", length=256, nullable=true)
     */
    private $streetWithType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="house", type="string", length=256, nullable=true)
     */
    private $house;

    /**
     * @var string|null
     *
     * @ORM\Column(name="block", type="string", length=256, nullable=true)
     */
    private $block;

    /**
     * @var int|null
     *
     * @ORM\Column(name="parent_company", type="integer", nullable=true)
     */
    private $parentCompany;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ek", type="decimal", precision=9, scale=2, nullable=true, options={"comment"="Эквайринг"})
     */
    private $ek;


}
