<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeRepository")
 * @ExclusionPolicy("all")
 */
class Type
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose()
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=105, unique=true)
     * @Expose()
     */
    private $slug;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hours", type="decimal", precision=10, scale=2)
     * @Expose()
     */
    private $hours=0;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     * @Expose()
     */
    private $color="#e01b1b";

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
     * @var template_events[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TemplateEvent", mappedBy="type",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     * @Expose()
     */
    private $template_events;

    public function __toString()
    {
        return $this->getSlug();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->template_events = new ArrayCollection();
        $this->color = "#e01b1b";
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
     * @return Type
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
     * @return Type
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
     * Set hours
     *
     * @param string $hours
     *
     * @return Type
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours
     *
     * @return string
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Type
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
     * @return Type
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
     * @return Type
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
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Type
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

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Type
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add templateEvent
     *
     * @param \AppBundle\Entity\TemplateEvent $templateEvent
     *
     * @return Type
     */
    public function addTemplateEvent(\AppBundle\Entity\TemplateEvent $templateEvent)
    {
        $this->template_events[] = $templateEvent;

        return $this;
    }

    /**
     * Remove templateEvent
     *
     * @param \AppBundle\Entity\TemplateEvent $templateEvent
     */
    public function removeTemplateEvent(\AppBundle\Entity\TemplateEvent $templateEvent)
    {
        $this->template_events->removeElement($templateEvent);
    }

    /**
     * Get templateEvents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemplateEvents()
    {
        return $this->template_events;
    }
}
