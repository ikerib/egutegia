<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 5/31/17
 * Time: 8:41 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NotificationService
{
    protected $u;
    protected $em;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->u = $tokenStorage->getToken()->getUser();
    }

    public function GetNotifications()
    {
        /** @var User $user */
        $user = $this->u;

        return $notifications = $this->em->getRepository( 'AppBundle:Notification' )->getAllUnread($user->getId());

    }

}