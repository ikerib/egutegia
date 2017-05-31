<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Notification controller.
 *
 * @Route("notification")
 */
class NotificationController extends Controller
{
    /**
     * Lists all notification entities.
     *
     * @Route("/", name="notification_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notifications = $em->getRepository('AppBundle:Notification')->findAll();

        return $this->render('notification/index.html.twig', array(
            'notifications' => $notifications,
        ));
    }

    /**
     * Finds and displays a notification entity.
     *
     * @Route("/{id}", name="notification_show")
     * @Method("GET")
     */
    public function showAction(Notification $notification)
    {

        return $this->render('notification/show.html.twig', array(
            'notification' => $notification,
        ));
    }
}
