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
use function count;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class DefaultController extends Controller
{
    /**
     * LDAP TALDEEN IZENAK MINUSKULAZ IPINI!!
     */

    /** @var array maps ldap groups to roles */
    private $groupMapping = [   // Definitely requires modification for your setup
        'taldea-sailburuak'             => 'ROLE_SAILBURUA'
    ];

    private $ldapTaldeak = [];
    private $ldapInfo = [];
    private $sailburuada = false;

    /** @var string extracts group name from dn string */
    private $groupNameRegExp = '/^CN=(?P<group>[^,]+)/i'; // You might want to change it to match your ldap server




    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(): RedirectResponse
    {
        return $this->redirectToRoute('user_homepage');
    }

    /**
     * @Route("/mycalendar", name="user_homepage")
     */
    public function userhomepageAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_UDALTZAINA')) {
            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'h1Textua' => $this->get('translator')->trans('error.udaltzaina'),
                    'h3Testua' => '',
                    'user'     => $user,
                ]
            );
        }


        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($user->getUsername(), date('Y'));

        if ((!$calendar) || (count($calendar) > 1)) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('dashboard');
            }

            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'h1Textua' => $this->get('translator')->trans('error.no.calendar'),
                    'h3Testua' => $this->get('translator')->trans('error.call.personal'),
                    'user'     => $user,
                ]
            );
        }

        /** @var Calendar $calendar */
        $calendar = $calendar[ 0 ];
        // norberarentzako orduak
        /** @var Event $selfHours */
        $selfHours         = $em->getRepository('AppBundle:Event')->findCalendarSelfEvents($calendar->getId());
        $selfHoursPartial  = 0;
        $selfHoursComplete = 0;

        foreach ($selfHours as $s) {
            /** @var Event $s */
            if ($s->getHours() < $calendar->getHoursDay()) {
                $selfHoursPartial += (float)$s->getHours();
            } else {
                $selfHoursComplete += (float)$s->getHours();
            }
        }

        //        $selfHoursPartial = round($calendar->getHoursSelfHalf() - $selfHoursPartial,2);
        $selfHoursPartial = round($calendar->getHoursSelfHalf(), 2);
        //        $selfHoursComplete = round( $calendar->getHoursSelf() - (float) $selfHoursComplete,2);
        $selfHoursComplete = round($calendar->getHoursSelf(), 2);


        return $this->render(
            'default/user_homepage.html.twig',
            [
                'user'              => $user,
                'calendar'          => $calendar,
                'selfHoursPartial'  => $selfHoursPartial,
                'selfHoursComplete' => $selfHoursComplete,
            ]
        );
    }

    /**
     * @Route("/fitxategiak", name="user_documents")
     */
    public function userdocumetsAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();
        /** @var Calendar $calendar */
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($user->getUsername(), date('Y'));

        if ((!$calendar) || (count($calendar) > 1)) {
            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'h1Textua' => $this->get('translator')->trans('error.no.calendar'),
                    'h3Testua' => $this->get('translator')->trans('error.call.personal'),
                    'user'     => $user,
                ]
            );
        }


        return $this->render(
            'default/fitxategiak.html.twig',
            [
                'user'     => $user,
                'calendar' => $calendar[ 0 ],
            ]
        );
    }

}
