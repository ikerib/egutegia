<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 11/8/18
 * Time: 2:23 PM
 */

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CalendarService
{
    protected $u;
    protected $em;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->u = $tokenStorage->getToken()->getUser();
    }

    function addEvent()
    {
        $em = $this->get('doctrine')->getEntityManager();
    }
}
