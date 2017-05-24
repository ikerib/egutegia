<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Eskaera
 *
 * @ORM\Table(name="eskaera")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EskaeraRepository")
 */
class Eskaera
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="noiz", type="datetime")
     */
    private $noiz;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hasi", type="datetime")
     */
    private $hasi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="amaitu", type="datetime")
     */
    private $amaitu;

    /**
     * @var string
     *
     * @ORM\Column(name="orduak", type="decimal", precision=10, scale=2)
     */
    private $orduak;

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
     * @var string
     *
     * @ORM\Column(nullable=true)
     * @Gedmo\Blameable(on="change", field={"title", "body"})
     */
    private $contentChangedBy;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    /**
     * @var \AppBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type", inversedBy="types")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $type;

    /**
     * @var \AppBundle\Entity\Calendar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar", inversedBy="calendars")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $calendar;

    /**
    * Constructor.
    */
    public function __construct()
    {
        $this->noiz = New \DateTime();
    }

    public function __toString()
    {
        return $this->getName();
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
     * @return Eskaera
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
     * Set hasi
     *
     * @param \DateTime $hasi
     *
     * @return Eskaera
     */
    public function setHasi($hasi)
    {
        $this->hasi = $hasi;

        return $this;
    }

    /**
     * Get hasi
     *
     * @return \DateTime
     */
    public function getHasi()
    {
        return $this->hasi;
    }

    /**
     * Set amaitu
     *
     * @param \DateTime $amaitu
     *
     * @return Eskaera
     */
    public function setAmaitu($amaitu)
    {
        $this->amaitu = $amaitu;

        return $this;
    }

    /**
     * Get amaitu
     *
     * @return \DateTime
     */
    public function getAmaitu()
    {
        return $this->amaitu;
    }

    /**
     * Set orduak
     *
     * @param string $orduak
     *
     * @return Eskaera
     */
    public function setOrduak($orduak)
    {
        $this->orduak = $orduak;

        return $this;
    }

    /**
     * Get orduak
     *
     * @return string
     */
    public function getOrduak()
    {
        return $this->orduak;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Eskaera
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
     * @return Eskaera
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
     * Set contentChangedBy
     *
     * @param string $contentChangedBy
     *
     * @return Eskaera
     */
    public function setContentChangedBy($contentChangedBy)
    {
        $this->contentChangedBy = $contentChangedBy;

        return $this;
    }

    /**
     * Get contentChangedBy
     *
     * @return string
     */
    public function getContentChangedBy()
    {
        return $this->contentChangedBy;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Eskaera
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
     * Set noiz
     *
     * @param \DateTime $noiz
     *
     * @return Eskaera
     */
    public function setNoiz($noiz)
    {
        $this->noiz = $noiz;

        return $this;
    }

    /**
     * Get noiz
     *
     * @return \DateTime
     */
    public function getNoiz()
    {
        return $this->noiz;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\Type $type
     *
     * @return Eskaera
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
     * Set calendar
     *
     * @param \AppBundle\Entity\Calendar $calendar
     *
     * @return Eskaera
     */
    public function setCalendar(\AppBundle\Entity\Calendar $calendar = null)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return \AppBundle\Entity\Calendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }
}
