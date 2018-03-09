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
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/zerrenda/konpentsauak", name="zerrenda_konpentsatuak")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function zerrendakonpentsatuakAction( Request $request )
    {

//        FORM POST PARAMETERS
        $hasi = $request->request->get( 'data_hasi' );
        $fin = $request->request->get( 'data_amaitu' );
        $urtea = $request->request->get( 'urtea' );
        $saila = $request->request->get( 'saila' );
        $lanpostua = $request->request->get( 'lanpostua' );
        $mota = $request->request->get( 'mota' );

        if ((!$urtea) && (!$mota) ){
            $urtea = date( "Y" );
            $mota = 6;
        }

        $em = $this->getDoctrine()->getManager();


        $konpentsatuak = $em->getRepository( 'AppBundle:Event' )->findKonpentsatuak( $hasi, $fin, $urtea, $saila, $lanpostua, $mota );
        $sailak = $em->getRepository( 'AppBundle:User' )->findSailGuztiak();
        $urteak = $em->getRepository( 'AppBundle:Calendar' )->getEgutegiUrteak();
        $lanpostuak = $em->getRepository( 'AppBundle:User' )->findLanpostuGuztiak();
        $motak = $em->getRepository( 'AppBundle:Type' )->findAll();


        $testua = $urtea . "-ko datuak erakusten ";
        if ( $hasi )
            $testua = $testua . $hasi . "-tik hasita ";
        if ( $fin )
            $testua = $testua . $fin . "-erarte. ";
        if ( $saila )
            $testua = $testua . " Saila:" . $saila;
        if ( $lanpostua )
            $testua = $testua . " Lanpostua:" . $lanpostua;
        if ( $mota ) {
            $motatest = $em->getRepository( 'AppBundle:Type' )->find( $mota );
            if ( $motatest ) {
                $testua = $testua . " Mota:" . $motatest->getName();
            }

        }


        return $this->render(
            'default/zerrenda_konpentsatuak.html.twig',
            [
                'konpentsatuak' => $konpentsatuak,
                'sailak'        => $sailak,
                'lanpostuak'    => $lanpostuak,
                'urteak'        => $urteak,
                'motak'         => $motak,
                'testua'        => $testua,
            ]
        );
    }

    /**
     * @Route("/mycalendar", name="user_homepage")
     */
    public function userhomepageAction()
    {
        $this->denyAccessUnlessGranted( 'ROLE_USER', null, 'Egin login' );

        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();

        if ( $this->get( 'security.authorization_checker' )->isGranted( 'ROLE_UDALTZAINA' ) ) {
            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'h1Textua' => $this->get('translator')->trans('error.udaltzaina'),
                    'h3Testua' => '',
                    'user'     => $user,
                ]
            );

        }


        $calendar = $em->getRepository( 'AppBundle:Calendar' )->findByUsernameYear( $user->getUsername(), date( 'Y' ) );

        if ( ( !$calendar ) || ( count( $calendar ) > 1 ) ) {
            if ( $this->get( 'security.authorization_checker' )->isGranted( 'ROLE_ADMIN' ) ) {
                return $this->redirectToRoute( 'dashboard' );
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
        $selfHours = $em->getRepository( 'AppBundle:Event' )->findCalendarSelfEvents( $calendar->getId() );
        $selfHoursPartial = 0;
        $selfHoursComplete = 0;

        foreach ( $selfHours as $s ) {
            /** @var Event $s */
            if ( $s->getHours() < $calendar->getHoursDay() ) {
                $selfHoursPartial += (float)$s->getHours();
            } else {
                $selfHoursComplete += (float)$s->getHours();
            }
        }

        $selfHoursPartial = (float)$calendar->getHoursSelfHalf() - $selfHoursPartial;
        $selfHoursComplete = (float)$calendar->getHoursSelf() - $selfHoursPartial;


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
    public function userdocumetsAction()
    {
        $this->denyAccessUnlessGranted( 'ROLE_USER', null, 'Egin login' );

        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user = $this->getUser();
        $calendar = $em->getRepository( 'AppBundle:Calendar' )->findByUsernameYear( $user->getUsername(), date( 'Y' ) );

        if ( ( !$calendar ) || ( count( $calendar ) > 1 ) ) {
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
