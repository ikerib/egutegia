<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User.
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ExclusionPolicy("all")
 */
class User implements UserInterface
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
     * @Expose
     */
    protected $department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $displayname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $nan;

    /**
     * @ORM\Column(type="boolean", length=255, nullable=true, options={"default": false})
     * @Expose
     */
    protected $sailburuada;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $ldapsaila;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $hizkuntza;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $lanpostua;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $notes;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    protected $members = [];

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    protected $password;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=false)
     */
    protected $username;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $enabled;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var calendars[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Calendar", mappedBy="user",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $calendars;

    /**
     * @var \AppBundle\Entity\Notification
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="user")
     */
    protected $notifications;

    /**
     * @var \AppBundle\Entity\Eskaera
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Eskaera", mappedBy="user")
     */
    protected $eskaera;

    /**
     * @var \AppBundle\Entity\Firmadet
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Firmadet", mappedBy="firmatzailea")
     */
    protected $firmadet;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->members = [];
        $this->calendars = new ArrayCollection();
        if (empty($this->roles)) {
            $this->roles[] = 'ROLE_USER';
        }
    }

    public function __toString()
    {
        return $this->getUsername();
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
    public function setDn($dn)
    {
        $this->dn = $dn;
    }

    /**
     * Get Ldap Distinguished Name.
     *
     * @return null|string Distinguished Name
     */
    public function getDn()
    {
        return $this->dn;
    }

    /**
     * Add calendar.
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
     * Remove calendar.
     *
     * @param \AppBundle\Entity\Calendar $calendar
     */
    public function removeCalendar(\AppBundle\Entity\Calendar $calendar)
    {
        $this->calendars->removeElement($calendar);
    }

    /**
     * Get calendars.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalendars()
    {
        return $this->calendars;
    }

    /**
     * Set department.
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
     * Get department.
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set displayname.
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
     * Get displayname.
     *
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * Set nan.
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
     * Get nan.
     *
     * @return string
     */
    public function getNan()
    {
        return $this->nan;
    }

    /**
     * Set lanpostua.
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
     * Get lanpostua.
     *
     * @return string
     */
    public function getLanpostua()
    {
        return $this->lanpostua;
    }

    /**
     * Set notes.
     *
     * @param string $notes
     *
     * @return User
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add notification
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return User
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
     * Add eskaera
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     *
     * @return User
     */
    public function addEskaera(\AppBundle\Entity\Eskaera $eskaera)
    {
        $this->eskaera[] = $eskaera;

        return $this;
    }

    /**
     * Remove eskaera
     *
     * @param \AppBundle\Entity\Eskaera $eskaera
     */
    public function removeEskaera(\AppBundle\Entity\Eskaera $eskaera)
    {
        $this->eskaera->removeElement($eskaera);
    }

    /**
     * Get eskaera
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEskaera()
    {
        return $this->eskaera;
    }

    /**
     * Add firmadet
     *
     * @param \AppBundle\Entity\Firmadet $firmadet
     *
     * @return User
     */
    public function addFirmadet(\AppBundle\Entity\Firmadet $firmadet)
    {
        $this->firmadet[] = $firmadet;

        return $this;
    }

    /**
     * Remove firmadet
     *
     * @param \AppBundle\Entity\Firmadet $firmadet
     */
    public function removeFirmadet(\AppBundle\Entity\Firmadet $firmadet)
    {
        $this->firmadet->removeElement($firmadet);
    }

    /**
     * Get firmadet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirmadet()
    {
        return $this->firmadet;
    }


    /**
     * Set hizkuntza.
     *
     * @param string|null $hizkuntza
     *
     * @return User
     */
    public function setHizkuntza($hizkuntza = null)
    {
        $this->hizkuntza = $hizkuntza;

        return $this;
    }

    /**
     * Get hizkuntza.
     *
     * @return string|null
     */
    public function getHizkuntza()
    {
        return $this->hizkuntza;
    }

    /**
     * Set sailburuada.
     *
     * @param bool|null $sailburuada
     *
     * @return User
     */
    public function setSailburuada($sailburuada = null)
    {
        $this->sailburuada = $sailburuada;

        return $this;
    }

    /**
     * Get sailburuada.
     *
     * @return bool|null
     */
    public function getSailburuada()
    {
        return $this->sailburuada;
    }

    /**
     * Set ldapsaila.
     *
     * @param string|null $ldapsaila
     *
     * @return User
     */
    public function setLdapsaila($ldapsaila = null)
    {
        $this->ldapsaila = $ldapsaila;

        return $this;
    }

    /**
     * Get ldapsaila.
     *
     * @return string|null
     */
    public function getLdapsaila()
    {
        return $this->ldapsaila;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

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
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set roles.
     *
     * @param json $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set enabled.
     *
     * @param bool|null $enabled
     *
     * @return User
     */
    public function setEnabled($enabled = null)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return bool|null
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
}
