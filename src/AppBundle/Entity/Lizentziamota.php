<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Lizentziamota
 *
 * @ORM\Table(name="lizentziamota")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LizentziamotaRepository")
 */
class Lizentziamota
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
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var bool
     *
     * @ORM\Column(name="sinatubehar", type="boolean", nullable=true)
     */
    private $sinatubehar;


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
     * @var \AppBundle\Entity\Eskaera
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Eskaera", mappedBy="lizentziamota")
     */
    protected $eskaerak;

    public function __toString()
    {
        return (string) $this->getName().'';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eskaerak = new ArrayCollection();
    }


    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Lizentziamota
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set sinatubehar.
     *
     * @param bool|null $sinatubehar
     *
     * @return Lizentziamota
     */
    public function setSinatubehar($sinatubehar = null)
    {
        $this->sinatubehar = $sinatubehar;

        return $this;
    }

    /**
     * Get sinatubehar.
     *
     * @return bool|null
     */
    public function getSinatubehar()
    {
        return $this->sinatubehar;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Lizentziamota
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Lizentziamota
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add eskaerak.
     *
     * @param \AppBundle\Entity\Eskaera $eskaerak
     *
     * @return Lizentziamota
     */
    public function addEskaerak(\AppBundle\Entity\Eskaera $eskaerak)
    {
        $this->eskaerak[] = $eskaerak;

        return $this;
    }

    /**
     * Remove eskaerak.
     *
     * @param \AppBundle\Entity\Eskaera $eskaerak
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEskaerak(\AppBundle\Entity\Eskaera $eskaerak)
    {
        return $this->eskaerak->removeElement($eskaerak);
    }

    /**
     * Get eskaerak.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEskaerak()
    {
        return $this->eskaerak;
    }
}
