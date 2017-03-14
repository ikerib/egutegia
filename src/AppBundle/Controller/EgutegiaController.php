<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Calendar controller.
 *
 * @Route("egutegia")
 */
class EgutegiaController extends Controller
{
    /**
     * Lists all calendar entities.
     *
     * @Route("/{username}", name="egutegia_user")
     * @Method("GET")
     */
    public function useregutegiaAction($username)
    {
        $em = $this->getDoctrine()->getManager();
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsername($username);

        return $this->render('egutegia/user_egutegia.html.twig', array(
            'calendar' => $calendar,
            'username' => $username
        ));
    }
}
