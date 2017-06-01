<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Firmadet
 *
 * @ORM\Table(name="firmadet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FirmadetRepository")
 * @ExclusionPolicy("all")
 */
class Firmadet
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
     * @var \DateTime
     *
     * @ORM\Column(name="noiz", type="datetime")
     */
    private $noiz;

    /**
     * @var bool
     *
     * @ORM\Column(name="firmatua", type="boolean")
     */
    private $firmatua;

    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;

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

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/


    /**
     * @var \AppBundle\Entity\Firma
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Firma", inversedBy="firmadet")
     * @ORM\JoinColumn(name="firma_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $firma;

    /**
     * @var \AppBundle\Entity\Sinatzaileakdet
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Sinatzaileakdet", inversedBy="firmadet")
     * @ORM\JoinColumn(name="sinatzaileak_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $sinatzaileakdet;


    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="firmadet")
     * @ORM\JoinColumn(name="firmatzaile_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $firmatzailea;


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
     * Set noiz
     *
     * @param \DateTime $noiz
     *
     * @return Firmadet
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
     * Set firmatua
     *
     * @param boolean $firmatua
     *
     * @return Firmadet
     */
    public function setFirmatua($firmatua)
    {
        $this->firmatua = $firmatua;

        return $this;
    }

    /**
     * Get firmatua
     *
     * @return boolean
     */
    public function getFirmatua()
    {
        return $this->firmatua;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Firmadet
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Firmadet
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
     * @return Firmadet
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
     * Set firma
     *
     * @param \AppBundle\Entity\Firma $firma
     *
     * @return Firmadet
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
     * Set sinatzaileakdet
     *
     * @param \AppBundle\Entity\Sinatzaileakdet $sinatzaileakdet
     *
     * @return Firmadet
     */
    public function setSinatzaileakdet(\AppBundle\Entity\Sinatzaileakdet $sinatzaileakdet = null)
    {
        $this->sinatzaileakdet = $sinatzaileakdet;

        return $this;
    }

    /**
     * Get sinatzaileakdet
     *
     * @return \AppBundle\Entity\Sinatzaileakdet
     */
    public function getSinatzaileakdet()
    {
        return $this->sinatzaileakdet;
    }

    /**
     * Set sinatzailea
     *
     * @param \AppBundle\Entity\User $sinatzailea
     *
     * @return Firmadet
     */
    public function setSinatzailea(\AppBundle\Entity\User $sinatzailea = null)
    {
        $this->sinatzailea = $sinatzailea;

        return $this;
    }

    /**
     * Get sinatzailea
     *
     * @return \AppBundle\Entity\User
     */
    public function getSinatzailea()
    {
        return $this->sinatzailea;
    }

    /**
     * Set firmatzailea
     *
     * @param \AppBundle\Entity\User $firmatzailea
     *
     * @return Firmadet
     */
    public function setFirmatzailea(\AppBundle\Entity\User $firmatzailea = null)
    {
        $this->firmatzailea = $firmatzailea;

        return $this;
    }

    /**
     * Get firmatzailea
     *
     * @return \AppBundle\Entity\User
     */
    public function getFirmatzailea()
    {
        return $this->firmatzailea;
    }
}
