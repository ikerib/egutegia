<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints\Date;


/**
 * Calendar
 *
 * @ORM\Table(name="calendar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalendarRepository")
 * @ExclusionPolicy("all")
 */
class Calendar {

    /**
     * @var int
     * @Expose
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Expose
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var double
     * @Expose
     *
     * @ORM\Column(name="lan_orduak_guztira", type="string", length=255)
     */
    private $lan_orduak_guztira=1500;

    /**
     * @var double
     * @Expose
     *
     * @ORM\Column(name="opor_orduak_guztira", type="string", length=255)
     */
    private $opor_orduak_guztira=0;

    /**
     * @var double
     * @Expose
     *
     * @ORM\Column(name="opor_orduak_hartuta", type="string", length=255)
     */
    private $opor_orduak_hartuta=0;

    /**
     * @var \DateTime
     * @Expose
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $start_date;

    /**
     * @var \DateTime
     * @Expose
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $end_date;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=105, unique=true)
     * @Expose
     */
    private $slug;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(name="name_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"name"})
     */
    private $nameChanged;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    /**
     * @var \AppBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $type;

    public function __toString()
    {
        return $this->getSlug();
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Calendar
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Calendar
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Calendar
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Calendar
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set nameChanged
     *
     * @param \DateTime $nameChanged
     *
     * @return Calendar
     */
    public function setNameChanged($nameChanged)
    {
        $this->nameChanged = $nameChanged;

        return $this;
    }

    /**
     * Get nameChanged
     *
     * @return \DateTime
     */
    public function getNameChanged()
    {
        return $this->nameChanged;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Calendar
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\Type $type
     *
     * @return Calendar
     */
    public function setType(\AppBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set lanOrduakGuztira
     *
     * @param string $lanOrduakGuztira
     *
     * @return Calendar
     */
    public function setLanOrduakGuztira($lanOrduakGuztira)
    {
        $this->lan_orduak_guztira = $lanOrduakGuztira;

        return $this;
    }

    /**
     * Get lanOrduakGuztira
     *
     * @return string
     */
    public function getLanOrduakGuztira()
    {
        return $this->lan_orduak_guztira;
    }

    /**
     * Set oporOrduakGuztira
     *
     * @param string $oporOrduakGuztira
     *
     * @return Calendar
     */
    public function setOporOrduakGuztira($oporOrduakGuztira)
    {
        $this->opor_orduak_guztira = $oporOrduakGuztira;

        return $this;
    }

    /**
     * Get oporOrduakGuztira
     *
     * @return string
     */
    public function getOporOrduakGuztira()
    {
        return $this->opor_orduak_guztira;
    }

    /**
     * Set oporOrduakHartuta
     *
     * @param string $oporOrduakHartuta
     *
     * @return Calendar
     */
    public function setOporOrduakHartuta($oporOrduakHartuta)
    {
        $this->opor_orduak_hartuta = $oporOrduakHartuta;

        return $this;
    }

    /**
     * Get oporOrduakHartuta
     *
     * @return string
     */
    public function getOporOrduakHartuta()
    {
        return $this->opor_orduak_hartuta;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Calendar
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Calendar
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }
}
