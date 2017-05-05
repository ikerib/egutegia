<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
use AppBundle\Entity\EventHistory;
use AppBundle\Entity\File;
use AppBundle\Entity\Log;
use AppBundle\Entity\TemplateEvent;
use AppBundle\Entity\User;
use AppBundle\Form\CalendarNoteType;
use AppBundle\Form\UserfileType;
use AppBundle\Form\UserNoteType;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use HttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ApiController extends FOSRestController {

    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** TEMPLATE ****** ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /**
     * Get template Info
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Get template info",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param $id
     * @return array|View
     * @Annotations\View()
     * @Get("/template/{id}")
     */
    public function getTemplateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $template = $em->getRepository('AppBundle:Template')->find($id);

        if ($template === null)
        {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $template;
    }


    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** TEMPLATE EVENTS ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /**
     * Get template Events
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Get template events",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param $templateid
     * @return array|View
     * @Annotations\View()
     * @Get("/templateevents/{templateid}")
     */
    public function getTemplateEventsAction($templateid)
    {
        $em = $this->getDoctrine()->getManager();

        $tevents = $em->getRepository('AppBundle:TemplateEvent')->getTemplateEvents($templateid);

        if ($tevents === null)
        {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $tevents;
    }

    /**
     * Save events.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Save a event",
     *   statusCodes = {
     *     200 = "OK response"
     *   }
     * )
     *
     * @var Request $request
     * @Annotations\View()
     * @param Request $request
     * @return static
     */
    public function postTemplateEventsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $jsonData = json_decode($request->getContent(), true);

        // bilatu egutegia
        $template = $em->getRepository('AppBundle:Template')->find($jsonData['templateid']);

        // bilatu egutegia
        $type = $em->getRepository('AppBundle:Type')->find($jsonData['type']);

        /** @var TemplateEvent $templateevent */
        $templateevent = new TemplateEvent();
        $templateevent->setTemplate($template);
        $templateevent->setType($type);
        $templateevent->setName($jsonData['name']);
        $tempini = new \DateTime($jsonData['startDate']);
        $templateevent->setStartDate($tempini);
        $tempfin = new \DateTime($jsonData['endDate']);
        $templateevent->setEndDate($tempfin);

        $em->persist($templateevent);
        $em->flush();

        $view = View::create();
        $view->setData($templateevent);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        return $view;

    }// "post_templateevents"            [POST] /templateevents

    /**
     * Delete template Events
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Delete template events",
     *   statusCodes = {
     *     204 = "OK"
     *   }
     * )
     *
     * @param $templateid
     *
     * @Rest\Delete("/templateevents/{templateid}")
     * @Rest\View(statusCode=204)
     * @return array
     */
    public function deleteTemplateEventsAction($templateid)
    {
        $em = $this->getDoctrine()->getManager();

        $template = $em->getRepository('AppBundle:Template')->find($templateid);

        if ($template=== null)
        {
            return new View("there are no Template events exist", Response::HTTP_NOT_FOUND);
        }

        $tevents = $template->getTemplateEvents();
        foreach ($tevents as $t) {
            $em->remove($t);
        }
        $em->flush();
    }


    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** CALENDAR EVENTS ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /**
     * Get calendar Events
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Get calendar events",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param $calendarid
     * @return array|View
     * @Annotations\View()
     * @Get("/events/{calendarid}")
     */
    public function getEventsAction($calendarid)
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->getEvents($calendarid);

        if ($events === null)
        {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $events;
    }

    /**
     * Save events.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Save a event",
     *   statusCodes = {
     *     200 = "OK response"
     *   }
     * )
     *
     * @var Request $request
     * @Annotations\View()
     * @param Request $request
     * @return static
     */
    public function postEventsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $jsonData = json_decode($request->getContent(), true);

        // find calendar
        $calendar = $em->getRepository('AppBundle:Calendar')->find($jsonData['calendarid']);

        // find type
        $type = $em->getRepository('AppBundle:Type')->find($jsonData['type']);


        /** @var Event $event */
        $event = new Event();
        $event->setCalendar($calendar);
        $event->setName($jsonData['name']);
        $tempini = new \DateTime($jsonData['startDate']);
        $event->setStartDate($tempini);
        $tempfin = new \DateTime($jsonData['endDate']);
        $event->setEndDate($tempfin);
        $event->setHours($jsonData[ 'hours' ]);
        $event->setType($type);
        $em->persist($event);


        /**
         * Ordu eragiketak egin soilik mota hauetako Event bat denean
         */

        $KalkuluakEgin = ['Oporrak', 'Norberarentzako', 'Konpentsatuak' ];

        if ( in_array($event->getType()->getName(), $KalkuluakEgin) ) {
            /** @var  $query */
            $query = $em->createQuery(
                '
                        UPDATE AppBundle:Calendar c
                        SET c.hours_year = c.hours_year - :hoursYear  
                        , c.hours_free = c.hours_free - :hoursFree  
                        , c.hours_self = c.hours_self - :hoursSelf
                        , c.hours_compensed = c.hours_compensed - :hoursCompensed 
                        WHERE c.id = :calendarid'
            );
            $query->setParameter( 'calendarid', $jsonData[ 'calendarid' ] );

            if ( $event->getType()->getName() === "Oporrak" ) {
                $query->setParameter( 'hoursYear', 0 );
                $query->setParameter( 'hoursFree', $event->getHours() );
                $query->setParameter( 'hoursSelf', 0 );
                $query->setParameter( 'hoursCompensed', 0 );
            } elseif ( $event->getType()->getName() === "Norberarentzako" ) {
                $query->setParameter( 'hoursYear', 0 );
                $query->setParameter( 'hoursFree', 0 );
                $query->setParameter( 'hoursSelf', $event->getHours() );
                $query->setParameter( 'hoursCompensed', 0 );
            } elseif ( $event->getType()->getName() === "Konpentsatuak" ) {
                $query->setParameter( 'hoursYear', 0 );
                $query->setParameter( 'hoursFree', 0 );
                $query->setParameter( 'hoursSelf', 0 );
                $query->setParameter( 'hoursCompensed', $event->getHours() );
            }

            /** @var Log $log */
            $log = new Log();
            $log->setName( "Egutegia eguneratua" );
            $log->setCalendar( $calendar );
            $log->setDescription( "Egutegian aldaketak grabatu dira " );
            $log->setQuery( $query->getSql() );
            $em->persist( $log );


            $query->execute();
        }
        $em->flush();

        $view = View::create();
        $view->setData($event);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        return $view;

    }// "post_events"            [POST] /events

    /**
     * Backup all events of a given calendar
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Save a calendar events to history",
     *   statusCodes = {
     *     200 = "OK response"
     *   }
     * )
     *
     * @Annotations\View()
     * @param Request $request
     * @param $calendarid
     * @return array|View
     * @Rest\Post("/backup/{calendarid}")
     */
    public function backupEventsAction(Request $request, $calendarid)
    {
        $em = $this->getDoctrine()->getManager();

        // find calendar
        $calendar = $em->getRepository('AppBundle:Calendar')->find($calendarid);

        // get all events from given calendar
        $events = $em->getRepository('AppBundle:Event')->findBy(
            array(
                'calendar' => $calendarid,
            )
        );

        foreach ($events as $e) {

            /** @var EventHistory $eventhistory */
            $eventhistory = new EventHistory();
            $eventhistory->setCalendar($calendar);
            $eventhistory->setName($e->getName());
            $eventhistory->setStartDate($e->getStartDate());
            $eventhistory->setEndDate($e->getEndDate());
            $eventhistory->setHours($e->getHours());
            $eventhistory->setType($e->getType());

            /** @var $log Log */
            $log = New Log();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $log->setUser($user);
            $log->setCalendar($calendar);
            $log->setEvent($e);
            $log->setName("Backup");
            $log->setDescription($e->getCalendar()->getUser()->getDisplayname() . " erabailtzailearen . ".$calendar->getName()." egutegiaren segurtasun kopia");

            $em->persist($eventhistory);
            $em->persist($log);

        }
        $em->flush();

        // Now we can remove calendar events but first we need to update calendar hours
        foreach ($events as $e) {

            $query = $em->createQuery('
                UPDATE AppBundle:Calendar c
                SET c.hours_year = c.hours_year + :hoursYear  
                , c.hours_free = c.hours_free + :hoursFree  
                , c.hours_self = c.hours_self + :hoursSelf
                , c.hours_compensed = c.hours_compensed +:hoursCompensed 
                WHERE c.id = :calendarid');
            $query->setParameter('calendarid', $calendarid);

            if ( $e->getType()->getName() === "Oporrak" ) {
                $query->setParameter('hoursYear', 0);
                $query->setParameter('hoursFree', $e->getHours());
                $query->setParameter('hoursSelf', 0);
                $query->setParameter('hoursCompensed', 0);
            } elseif ($e->getType()->getName() === "Norberarentzako") {
                $query->setParameter('hoursYear', 0);
                $query->setParameter('hoursFree', 0);
                $query->setParameter('hoursSelf', $e->getHours());
                $query->setParameter('hoursCompensed', 0);
            } elseif ($e->getType()->getName() === "Konpentsatuak") {
                $query->setParameter('hoursYear', 0);
                $query->setParameter('hoursFree', 0);
                $query->setParameter('hoursSelf', 0);
                $query->setParameter('hoursCompensed', $e->getHours());
            }

            /** @var Log $log */
            $log = new Log();
            $log->setName("Update Calendar hours");
            $log->setDescription($query->getSql());
            $em->persist($log);
            $em->flush();

            $query->execute();
        }

        /** @var $query QueryBuilder */
        $query = $em->createQuery('DELETE AppBundle:Event e WHERE e.calendar = :calendarid');
        $query->setParameter('calendarid', $calendarid);
        $query->execute();

        $view = View::create();
        $view->setData($calendar);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        return $view;

    }

    /**
     * Save Notes.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Save calendar notes",
     *   statusCodes = {
     *     200 = "OK response"
     *   }
     * )
     *
     * @param Request $request
     * @param         $calendarid
     *
     * @return static
     * @throws HttpException
     * @Annotations\View()
     */
    public function postNotesAction(Request $request, $calendarid )
    {
        $em = $this->getDoctrine()->getManager();
        $calendar = $em->getRepository('AppBundle:Calendar')->find($calendarid);

        $frmnote = $this->createForm(
            CalendarNoteType::class,
            $calendar
        );
        $frmnote->handleRequest( $request );
        if ( $frmnote->isValid( ) ) {

            $em->persist($calendar);

            /** @var Log $log */
            $log = new Log();
            $log->setName("Egutegiaren oharrak eguneratuak");
            $log->setDescription('Testua eguneratua');
            $em->persist($log);
            $em->flush();

            $view = View::create();
            $view->setData($calendar);

            header('content-type: application/json; charset=utf-8');
            header("access-control-allow-origin: *");

            return $view;
        } else {
            throw new HttpException(400, "ez da topatu.");
        }



    }// "post_notes"            [POST] /notes/{calendarid}

    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** USER API        ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /**
     * Save user notes.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Save user notes",
     *   statusCodes = {
     *     200 = "OK response"
     *   }
     * )
     *
     * @param Request $request
     * @param         $username
     *
     * @return static
     * @throws HttpException
     * @Annotations\View()
     */
    public function postUsernotesAction(Request $request, $username)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->getByUsername($username);

        $jsonData = json_decode($request->getContent(), true);

        $userManager = $this->container->get( 'fos_user.user_manager' );

        if (!$user) {
            $ldap = $this->get('ldap_tools.ldap_manager');
            $ldapuser = $ldap->buildLdapQuery()
                ->select(['name', 'guid', 'username', 'emailAddress', 'firstName', 'lastName', 'dn', 'department', 'description'])
                ->fromUsers()
                ->where($ldap->buildLdapQuery()->filter()->eq('username', $username))
                ->orderBy('username')
                ->getLdapQuery()
                ->getSingleResult();


            /** @var $user User */
            $user = $userManager->createUser();
            $user->setUsername( $username );
            $user->setEmail( $username . '@pasaia.net' );
            $user->setPassword( '' );
            if ($ldapuser->has('dn')) {
                $user->setDn( $ldapuser->getDn() );
            }
            $user->setEnabled( true );
            if ($ldapuser->has('description')) {
                $user->setLanpostua( $ldapuser->getDescription() );
            }
            if ($ldapuser->has('department')) {
                $user->setDepartment( $ldapuser->getDepartment() );
            }



        }

        $user->setNotes($jsonData['notes']);

        $userManager->updateUser( $user );

        $view = View::create();
        $view->setData($user);

        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        return $view;



    }// "post_usernotes"            [POST] /usernotes/{userid}
}