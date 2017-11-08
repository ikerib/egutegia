<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
;

/**
 * Konpentsatuak
 *
 * @ORM\Table(name="konpentsatuak")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KonpentsatuakRepository")
 */
class Konpentsatuak
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="noiz", type="datetime", nullable=true)
     */
    private $noiz;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hasi", type="datetime", nullable=true)
     */
    private $hasi;

    /**
     * @var string
     *
     * @ORM\Column(name="egunak", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $egunak;

    /**
     * @var string
     *
     * @ORM\Column(name="orduak", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $orduak;

    /**
     * @var string
     *
     * @ORM\Column(name="deskribapena", type="string", length=255, nullable=true)
     */
    private $deskribapena;


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

    /**
     * @var bool
     * @ORM\Column(name="abiatua", type="boolean", nullable=true, options={"default"=false})
     */
    private $abiatua = false;

    /**
     * @var bool
     * @ORM\Column(name="amaitua", type="boolean", nullable=true, options={"default"=false})
     */
    private $amaitua = false;

    /**
     * @var bool
     * @ORM\Column(name="egutegian", type="boolean", nullable=true, options={"default"=false})
     */
    private $egutegian = false;

    /**
     * @var string
     * @ORM\Column(name="oharra", type="string", nullable=true)
     */
    private $oharra;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="eskaera")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    /**
     * @var \AppBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type", inversedBy="eskaera")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $type;

    /**
     * @var \AppBundle\Entity\Calendar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar", inversedBy="eskaeras")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $calendar;

    /**
     * @var \AppBundle\Entity\Sinatzaileak
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sinatzaileak", inversedBy="eskaera")
     * @ORM\JoinColumn(name="sinatzaileak_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $sinatzaileak;

    /**
     * @var \AppBundle\Entity\Notification
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="eskaera")
     */
    protected $notifications;


    /**
     * @var \AppBundle\Entity\Firma
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Firma", mappedBy="eskaera")
     */
    protected $firma;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->noiz = New \DateTime();
        $this->abiatua = false;
        $this->amaitua = false;
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
     * @return Konpentsatuak
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
     * Set noiz
     *
     * @param \DateTime $noiz
     *
     * @return Konpentsatuak
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
     * Set hasi
     *
     * @param \DateTime $hasi
     *
     * @return Konpentsatuak
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
     * Set egunak
     *
     * @param string $egunak
     *
     * @return Konpentsatuak
     */
    public function setEgunak($egunak)
    {
        $this->egunak = $egunak;

        return $this;
    }

    /**
     * Get egunak
     *
     * @return string
     */
    public function getEgunak()
    {
        return $this->egunak;
    }

    /**
     * Set orduak
     *
     * @param string $orduak
     *
     * @return Konpentsatuak
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
     * Set deskribapena
     *
     * @param string $deskribapena
     *
     * @return Konpentsatuak
     */
    public function setDeskribapena($deskribapena)
    {
        $this->deskribapena = $deskribapena;

        return $this;
    }

    /**
     * Get deskribapena
     *
     * @return string
     */
    public function getDeskribapena()
    {
        return $this->deskribapena;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Konpentsatuak
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
     * @return Konpentsatuak
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
     * @return Konpentsatuak
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
     * Set abiatua
     *
     * @param boolean $abiatua
     *
     * @return Konpentsatuak
     */
    public function setAbiatua($abiatua)
    {
        $this->abiatua = $abiatua;

        return $this;
    }

    /**
     * Get abiatua
     *
     * @return boolean
     */
    public function getAbiatua()
    {
        return $this->abiatua;
    }

    /**
     * Set amaitua
     *
     * @param boolean $amaitua
     *
     * @return Konpentsatuak
     */
    public function setAmaitua($amaitua)
    {
        $this->amaitua = $amaitua;

        return $this;
    }

    /**
     * Get amaitua
     *
     * @return boolean
     */
    public function getAmaitua()
    {
        return $this->amaitua;
    }

    /**
     * Set egutegian
     *
     * @param boolean $egutegian
     *
     * @return Konpentsatuak
     */
    public function setEgutegian($egutegian)
    {
        $this->egutegian = $egutegian;

        return $this;
    }

    /**
     * Get egutegian
     *
     * @return boolean
     */
    public function getEgutegian()
    {
        return $this->egutegian;
    }

    /**
     * Set oharra
     *
     * @param string $oharra
     *
     * @return Konpentsatuak
     */
    public function setOharra($oharra)
    {
        $this->oharra = $oharra;

        return $this;
    }

    /**
     * Get oharra
     *
     * @return string
     */
    public function getOharra()
    {
        return $this->oharra;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Konpentsatuak
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
     * @return Konpentsatuak
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
     * @return Konpentsatuak
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

    /**
     * Set sinatzaileak
     *
     * @param \AppBundle\Entity\Sinatzaileak $sinatzaileak
     *
     * @return Konpentsatuak
     */
    public function setSinatzaileak(\AppBundle\Entity\Sinatzaileak $sinatzaileak = null)
    {
        $this->sinatzaileak = $sinatzaileak;

        return $this;
    }

    /**
     * Get sinatzaileak
     *
     * @return \AppBundle\Entity\Sinatzaileak
     */
    public function getSinatzaileak()
    {
        return $this->sinatzaileak;
    }

    /**
     * Add notification
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return Konpentsatuak
     */
    public function addNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \AppBundle\Entity\Notification $notification
     */
    public function removeNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set firma
     *
     * @param \AppBundle\Entity\Firma $firma
     *
     * @return Konpentsatuak
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
}
