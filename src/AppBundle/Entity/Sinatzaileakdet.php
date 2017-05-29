<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Sinatzaileakdet
 *
 * @ORM\Table(name="sinatzaileakdet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SinatzaileakdetRepository")
 * @ExclusionPolicy("all")
 */
class Sinatzaileakdet
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
     * @var \AppBundle\Entity\Sinatzaileak
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sinatzaileak", inversedBy="sinatzaileakdet")
     * @ORM\JoinColumn(name="sinatzaileak_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $sinatzaileak;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="calendars")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    public function __toString()
    {
        return (string) $this->getId().'';
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Sinatzaileakdet
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
     * @return Sinatzaileakdet
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
     * @return Sinatzaileakdet
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
     * Set sinatzaileak
     *
     * @param \AppBundle\Entity\Sinatzaileak $sinatzaileak
     *
     * @return Sinatzaileakdet
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Sinatzaileakdet
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
}
