<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
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
     * @Route("/mycalendar", name="user_homepage")
     */
    public function userhomepageAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');


        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();

        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($user->getUsername(), date('Y'));

        if ((!$calendar) || (count($calendar) > 1)) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('dashboard');
            }
            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'user' => $user
                ]
            );
        }

        /** @var Calendar $calendar */
        $calendar = $calendar[ 0 ];
        // norberarentzako orduak
        /** @var Event $selfHours */
        $selfHours = $em->getRepository( 'AppBundle:Event' )->findCalendarSelfEvents( $calendar->getId() );
        $selfHoursPartial = 0;
        $selfHoursComplete = 0;

        foreach ($selfHours as $s) {
            /** @var Event $s */
            if ( $s->getHours() < $calendar->getHoursDay()) {
                $selfHoursPartial += (float)$s->getHours();
            } else {
                $selfHoursComplete +=(float)$s->getHours();
            }
        }

        $selfHoursPartial = (float)$calendar->getHoursSelfHalf() - $selfHoursPartial;
        $selfHoursComplete = (float)$calendar->getHoursSelf() - $selfHoursPartial;


        return $this->render(
            'default/user_homepage.html.twig',
            [
                'user' => $user,
                'calendar' => $calendar,
                'selfHoursPartial'=> $selfHoursPartial,
                'selfHoursComplete'=>$selfHoursComplete
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
