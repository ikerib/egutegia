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
     * @ORM\Column(name="amaitu", type="datetime", nullable=true)
     */
    private $amaitu;

    /**
     * @var string
     *
     * @ORM\Column(name="egunak", type="decimal", precision=10, scale=2)
     */
    private $egunak;

    /**
     * @var string
     *
     * @ORM\Column(name="orduak", type="decimal", precision=10, scale=2)
     */
    private $orduak;

    /**
     * @var decimal
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=2)
     */
    private $total = 0;

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
    private $abiatua=false;

    /**
     * @var bool
     * @ORM\Column(name="bideratua", type="boolean", nullable=true, options={"default"=false})
     */
    private $bideratua=false;

    /**
     * @var bool
     * @ORM\Column(name="amaitua", type="boolean", nullable=true, options={"default"=false})
     */
    private $amaitua=false;

    /**
     * @var bool
     * @ORM\Column(name="egutegian", type="boolean", nullable=true, options={"default"=false})
     */
    private $egutegian=false;

    /**
     * @var bool
     * @ORM\Column(name="konfliktoa", type="boolean", nullable=true, options={"default"=false})
     */
    private $konfliktoa=false;

    /**
     * @var bool
     * @ORM\Column(name="emaitza", type="boolean", nullable=true, options={"default"=false})
     */
    private $emaitza=true;

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
     * @var documents[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Document", mappedBy="eskaera",cascade={"persist", "remove"})
     * @ORM\OrderBy({"orden"="ASC"})
     */
    private $documents;

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
        $this->orduak = 0;
        $this->egunak = 0;
        $this->noiz = New \DateTime();
        $this->abiatua = false;
        $this->amaitua = false;
        $this->konfliktoa = false;
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

    /**
     * Set abiatua
     *
     * @param boolean $abiatua
     *
     * @return Eskaera
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
     * @return Eskaera
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
     * Set oharra
     *
     * @param string $oharra
     *
     * @return Eskaera
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
     * Set sinatzaileak
     *
     * @param \AppBundle\Entity\Sinatzaileak $sinatzaileak
     *
     * @return Eskaera
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
     * Add firma
     *
     * @param \AppBundle\Entity\Firma $firma
     *
     * @return Eskaera
     */
    public function addFirma(\AppBundle\Entity\Firma $firma)
    {
        $this->firma[] = $firma;

        return $this;
    }

    /**
     * Remove firma
     *
     * @param \AppBundle\Entity\Firma $firma
     */
    public function removeFirma(\AppBundle\Entity\Firma $firma)
    {
        $this->firma->removeElement($firma);
    }

    /**
     * Get firma
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set firma
     *
     * @param \AppBundle\Entity\Firma $firma
     *
     * @return Eskaera
     */
    public function setFirma(\AppBundle\Entity\Firma $firma = null)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Add notification
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return Eskaera
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
     * Set egutegian
     *
     * @param boolean $egutegian
     *
     * @return Eskaera
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
     * Set egunak
     *
     * @param string $egunak
     *
     * @return Eskaera
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
     * Set total
     *
     * @param string $total
     *
     * @return Eskaera
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Add document
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return Eskaera
     */
    public function addDocument(\AppBundle\Entity\Document $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \AppBundle\Entity\Document $document
     */
    public function removeDocument(\AppBundle\Entity\Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set bideratua.
     *
     * @param bool|null $bideratua
     *
     * @return Eskaera
     */
    public function setBideratua($bideratua = null)
    {
        $this->bideratua = $bideratua;

        return $this;
    }

    /**
     * Get bideratua.
     *
     * @return bool|null
     */
    public function getBideratua()
    {
        return $this->bideratua;
    }

    /**
     * Set konfliktoa.
     *
     * @param bool|null $konfliktoa
     *
     * @return Eskaera
     */
    public function setKonfliktoa($konfliktoa = null)
    {
        $this->konfliktoa = $konfliktoa;

        return $this;
    }

    /**
     * Get konfliktoa.
     *
     * @return bool|null
     */
    public function getKonfliktoa()
    {
        return $this->konfliktoa;
    }

    /**
     * Set emaitza.
     *
     * @param bool|null $emaitza
     *
     * @return Eskaera
     */
    public function setEmaitza($emaitza = null)
    {
        $this->emaitza = $emaitza;

        return $this;
    }

    /**
     * Get emaitza.
     *
     * @return bool|null
     */
    public function getEmaitza()
    {
        return $this->emaitza;
    }
}
