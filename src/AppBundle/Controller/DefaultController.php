<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        $user = $this->getUser();

        return $this->render(
            'default/homepage.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * @Route("/egutegia", name="user_homepage")
     */
    public function userhomepageAction()
    {
        //if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        //    return $this->redirectToRoute('dashboard');
        //}
        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($user->getUsername(), date('Y'));

        if ((!$calendar) || (count($calendar) > 1)) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('dashboard');
            }
            throw new EntityNotFoundException('Ez da egutegirik topatu edo egutegi bat baino gehiago ditu');
        }

        return $this->render(
            'default/user_homepage.html.twig',
            [
                'user' => $user,
                'calendar' => $calendar[0],
            ]
        );
    }
}
