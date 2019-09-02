<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/{username}", name="egutegia_user", methods={"GET"})
     *
     * @param mixed $username
     *
     * @return Response
     */
    public function useregutegiaAction($username): Response
    {
        $em = $this->getDoctrine()->getManager();
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsername($username);

        return $this->render('egutegia/user_egutegia.html.twig', [
            'calendar' => $calendar,
            'username' => $username,
        ]);
    }
}
