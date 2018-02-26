<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 * @ExclusionPolicy("all")
 */
class Notification
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="notified", type="boolean", nullable=true)
     */
    private $notified;

    /**
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    /**
     * @var bool
     *
     * @ORM\Column(name="completed", type="boolean")
     */
    private $completed;

    /**
     * @var bool
     *
     * @ORM\Column(name="result", type="boolean")
     */
    private $result;

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
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->completed = false;
        $this->readed = false;
        $this->result = false;
        $this->notified = false;
    }

    /**
     * @var \AppBundle\Entity\Firma
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Firma", inversedBy="notifications")
     * @ORM\JoinColumn(name="firma_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $firma;

    /**
     * @var \AppBundle\Entity\Eskaera
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Eskaera", inversedBy="notifications")
     * @ORM\JoinColumn(name="eskaera_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $eskaera;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    public function __toString()
    {
        return (string) $this->getName().'';
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
     * @return Notification
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
     * Set description
     *
     * @param string $description
     *
     * @return Notification
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set readed
     *
     * @param boolean $readed
     *
     * @return Notification
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;

        return $this;
    }

    /**
     * Get readed
     *
     * @return boolean
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     *
     * @return Notification
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set result
     *
     * @param boolean $result
     *
     * @return Notification
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return boolean
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Notification
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
     * @return Notification
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return Notification
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set firma
     *
     * @param \AppBundle\Entity\Firma $firma
     *
     * @return Notification
     */
    public function setFirma(\AppBundle\Entity\Firma $firma = null)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return \AppBundle\Entity\Firma
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set eskaera
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     *
     * @return Notification
     */
    public function setEskaera(\AppBundle\Entity\Eskaera $eskaera = null)
    {
        $this->eskaera = $eskaera;

        return $this;
    }

    /**
     * Get eskaera
     *
     * @return \AppBundle\Entity\Eskaera
     */
    public function getEskaera()
    {
        return $this->eskaera;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Notification
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
     * Set notified.
     *
     * @param bool|null $notified
     *
     * @return Notification
     */
    public function setNotified($notified = null)
    {
        $this->notified = $notified;

        return $this;
    }

    /**
     * Get notified.
     *
     * @return bool|null
     */
    public function getNotified()
    {
        return $this->notified;
    }
}
