<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Calendar
 *
 * @ORM\Table(name="calendar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalendarRepository")
 * @ExclusionPolicy("all")
 */
class Calendar
{
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
     * @var decimal
     * @Expose
     *
     * @ORM\Column(name="hours_year", type="decimal", precision=10, scale=2)
     */
    private $hours_year=0;

    /**
     * @var decimal
     * @Expose
     *
     * @ORM\Column(name="hours_free", type="decimal", precision=10, scale=2)
     */
    private $hours_free=0;

    /**
     * @var decimal
     * @Expose
     *
     * @ORM\Column(name="hours_self", type="decimal", precision=10, scale=2)
     */
    private $hours_self=0;

    /**
     * @var decimal
     * @Expose
     *
     * @ORM\Column(name="hours_compensed", type="decimal", precision=10, scale=2)
     */
    private $hours_compensed=0;

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
     * @var \AppBundle\Entity\Template
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Template")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $template;

    /**
     * @var events[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event", mappedBy="calendar",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

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
     * Set hoursYear
     *
     * @param string $hoursYear
     *
     * @return Calendar
     */
    public function setHoursYear($hoursYear)
    {
        $this->hours_year = $hoursYear;

        return $this;
    }

    /**
     * Get hoursYear
     *
     * @return string
     */
    public function getHoursYear()
    {
        return $this->hours_year;
    }

    /**
     * Set hoursFree
     *
     * @param string $hoursFree
     *
     * @return Calendar
     */
    public function setHoursFree($hoursFree)
    {
        $this->hours_free = $hoursFree;

        return $this;
    }

    /**
     * Get hoursFree
     *
     * @return string
     */
    public function getHoursFree()
    {
        return $this->hours_free;
    }

    /**
     * Set hoursSelf
     *
     * @param string $hoursSelf
     *
     * @return Calendar
     */
    public function setHoursSelf($hoursSelf)
    {
        $this->hours_self = $hoursSelf;

        return $this;
    }

    /**
     * Get hoursSelf
     *
     * @return string
     */
    public function getHoursSelf()
    {
        return $this->hours_self;
    }

    /**
     * Set hoursCompensed
     *
     * @param string $hoursCompensed
     *
     * @return Calendar
     */
    public function setHoursCompensed($hoursCompensed)
    {
        $this->hours_compensed = $hoursCompensed;

        return $this;
    }

    /**
     * Get hoursCompensed
     *
     * @return string
     */
    public function getHoursCompensed()
    {
        return $this->hours_compensed;
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
     * Set template
     *
     * @param \AppBundle\Entity\Template $template
     *
     * @return Calendar
     */
    public function setTemplate(\AppBundle\Entity\Template $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \AppBundle\Entity\Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Calendar
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $event
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }
}
