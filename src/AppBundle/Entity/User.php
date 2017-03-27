<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Query\Expr\Base;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use FR3D\LdapBundle\Model\LdapUserInterface;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ExclusionPolicy("all")
 */
class User extends BaseUser implements LdapUserInterface
{
    /**
     * @var int
     * @Expose
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $dn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $displayname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $nan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lanpostua;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $members = array();

    ///**
    // * @var members[]
    // * @ORM\Column(type="string")
    // */
    //protected $members;


    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var calendars[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Calendar", mappedBy="user",cascade={"persist"})
     * @ORM\OrderBy({"username" = "ASC"})
     */
    private $calendars;


    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->members = array();
        $this->calendars = new ArrayCollection();
        if (empty($this->roles)) {
            $this->roles[] = 'ROLE_USER';
        }
    }
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    //public function addMembers($member)  {
    //    if (!in_array($member, $this->members, true)) {
    //        $this->members[] = $member;
    //    }
    //
    //    return $this;
    //}
    //
    //public function getMembers()
    //{
    //    return array_unique($this->members);
    //}
    //
    //public function hasMembers($member)
    //{
    //    return in_array(strtoupper($member), $this->getMembers(), true);
    //}

    public function getMembers()
    {
        return $this->members;
    }

    public function setMembers(array $members)
    {
        $this->members = $members;

        // allows for chaining
        return $this;
    }


    /**
     * Set Ldap Distinguished Name.
     *
     * @param string $dn Distinguished Name
     */
    public function setDn ($dn)
    {
        $this->dn = $dn;
    }

    /**
     * Get Ldap Distinguished Name.
     *
     * @return null|string Distinguished Name
     */
    public function getDn ()
    {
        return $this->dn;
    }

    /**
     * Add calendar
     *
     * @param \AppBundle\Entity\Calendar $calendar
     *
     * @return User
     */
    public function addCalendar(\AppBundle\Entity\Calendar $calendar)
    {
        $this->calendars[] = $calendar;

        return $this;
    }

    /**
     * Remove calendar
     *
     * @param \AppBundle\Entity\Calendar $calendar
     */
    public function removeCalendar(\AppBundle\Entity\Calendar $calendar)
    {
        $this->calendars->removeElement($calendar);
    }

    /**
     * Get calendars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendars()
    {
        return $this->calendars;
    }

    /**
     * Set department
     *
     * @param string $department
     *
     * @return User
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set displayname
     *
     * @param string $displayname
     *
     * @return User
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * Get displayname
     *
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }



    /**
     * Set nan
     *
     * @param string $nan
     *
     * @return User
     */
    public function setNan($nan)
    {
        $this->nan = $nan;

        return $this;
    }

    /**
     * Get nan
     *
     * @return string
     */
    public function getNan()
    {
        return $this->nan;
    }

    /**
     * Set lanpostua
     *
     * @param string $lanpostua
     *
     * @return User
     */
    public function setLanpostua($lanpostua)
    {
        $this->lanpostua = $lanpostua;

        return $this;
    }

    /**
     * Get lanpostua
     *
     * @return string
     */
    public function getLanpostua()
    {
        return $this->lanpostua;
    }
}
