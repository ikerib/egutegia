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
use Symfony\Component\BrowserKit\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        return $this->redirectToRoute( 'user_homepage' );
    }

    /**
     * @Route("/egutegia", name="user_homepage")
     */
    public function userhomepageAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

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

    /**
     * @Route("/fitxategiak", name="user_documents")
     */
    public function userdocumetsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($user->getUsername(), date('Y'));

        if ((!$calendar) || (count($calendar) > 1)) {
            throw new EntityNotFoundException('Ez da egutegirik topatu.');
        }

        //$documents = $calendar->getDocuments();

        return $this->render(
            'default/fitxategiak.html.twig',
            [
                'user' => $user,
                'calendar' => $calendar[0],
                //'documents' => $documents
            ]
        );
    }

}
