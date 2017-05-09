<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
use AppBundle\Entity\EventHistory;
use AppBundle\Entity\Log;
use AppBundle\Entity\Template;
use AppBundle\Entity\TemplateEvent;
use AppBundle\Entity\Type;
use AppBundle\Entity\User;
use AppBundle\Form\CalendarNoteType;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use HttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Put;

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
     * Update a Event
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Update a Event",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param         $id
     *
     * @return static
     * @throws EntityNotFoundException
     * @Rest\View(statusCode=200)
     * @Rest\Put("/events/{id}")
     */
    public function putEventAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $jsonData = json_decode($request->getContent(), true);

        // find event
        $event = $em->getRepository( 'AppBundle:Event' )->find( $id );
        if (!$event) {
            throw new EntityNotFoundException();
        }

        // find calendar
        /** @var Calendar $calendar */
        $calendar = $em->getRepository('AppBundle:Calendar')->find($jsonData['calendarid']);

        // find type
        /** @var Type $type */
        $type = $em->getRepository('AppBundle:Type')->find($jsonData['type']);


        $event->setName($jsonData['name']);
        $tempini = new \DateTime($jsonData['startDate']);
        $event->setStartDate($tempini);
        $tempfin = new \DateTime($jsonData['endDate']);
        $event->setEndDate($tempfin);
        $event->setHours($jsonData[ 'hours' ]);
        $event->setType($type);
        $em->persist($event);

        $oldValue = $jsonData[ "oldValue" ];
        $newValue = $jsonData[ "hours" ];
        $oldType = $jsonData[ "oldType" ];
        $hours = floatval($event->getHours()) - floatval( $oldValue );


        if ( $type->getRelated() ) {

            if ( $type->getId() === intval($oldType) ) { // Mota berdinekoak badira, zuzenketa

                /** @var Type $t */
                $t = $event->getType();
                if ( $t->getRelated() === "hours_free" ) {
                    $calendar->setHoursFree( floatval($calendar->getHoursFree()) + $hours );
                }
                if ($t->getRelated() === "hours_self") {
                    $calendar->setHoursSelf( floatval($calendar->getHoursSelf()) + $hours );
                }
                if ($t->getRelated() === "hours_compensed") {
                    $calendar->setHoursCompensed( floatval($calendar->getHoursCompensed()) + $hours );
                }
                if ($t->getRelated() === "hours_sindical") {
                    $calendar->setHoursSindikal( floatval($calendar->getHoursSindikal()) + $hours );
                }
                $em->persist( $calendar );

            } else { // Mota ezberdinekoak dira, aurrena aurreko motan gehitu, mota berrian kentu ondoren


                /** @vat Type $tOld */
                $tOld = $em->getRepository( 'AppBundle:Type' )->find( $oldType );
                if ( $tOld->getRelated() === "hours_free" ) {
                    $calendar->setHoursFree( floatval($calendar->getHoursFree()) + $oldValue );
                }
                if ($tOld->getRelated() === "hours_self") {
                    $calendar->setHoursSelf( floatval($calendar->getHoursSelf()) + $oldValue );
                }
                if ($tOld->getRelated() === "hours_compensed") {
                    $calendar->setHoursCompensed( floatval($calendar->getHoursCompensed()) + $oldValue );
                }
                if ($tOld->getRelated() === "hours_sindical") {
                    $calendar->setHoursSindikal( floatval($calendar->getHoursSindikal()) + $oldValue );
                }

                /** @var Type $tNew */
                $tNew = $event->getType(); // Mota berria
                if ( $tNew->getRelated() === "hours_free" ) {
                    $calendar->setHoursFree( floatval($calendar->getHoursFree()) - $newValue );
                }
                if ($tNew->getRelated() === "hours_self") {
                    $calendar->setHoursSelf( floatval($calendar->getHoursSelf()) - $newValue );
                }
                if ($tNew->getRelated() === "hours_compensed") {
                    $calendar->setHoursCompensed( floatval($calendar->getHoursCompensed()) - $newValue );
                }
                if ($tNew->getRelated() === "hours_sindical") {
                    $calendar->setHoursSindikal( floatval($calendar->getHoursSindikal()) - $newValue );
                }

                $em->persist( $calendar );

            }



            /** @var Log $log */
            $log = new Log();
            $log->setName( "Egutegiko egun bat eguneratua izan da" );
            $log->setCalendar( $calendar );
            $log->setDescription( $event->getName()." ".$event->getHours(). " ordu ".$event->getType() );
            $em->persist( $log );



        }
        $em->flush();

        $view = View::create();
        $view->setData($event);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        return $view;

    }// "put_event"             [PUT] /events/{id}

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
        /** @var Type $type */
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


        if ( $type->getRelated() ) {

            /** @var Type $t */
            $t = $event->getType();
            if ( $t->getRelated() === "hours_free" ) {
                $calendar->setHoursFree( floatval( $calendar->getHoursFree() ) - floatval($jsonData[ 'hours' ]) );
            }
            if ( $t->getRelated() === "hours_self" ) {
                $calendar->setHoursSelf( floatval( $calendar->getHoursSelf() ) - floatval($jsonData[ 'hours' ]) );
            }
            if ( $t->getRelated() === "hours_compensed" ) {
                $calendar->setHoursCompensed( floatval( $calendar->getHoursCompensed() ) - floatval($jsonData[ 'hours' ]) );
            }
            if ( $t->getRelated() === "hours_sindical" ) {
                $calendar->setHoursSindikal( floatval( $calendar->getHoursSindikal() ) - floatval($jsonData[ 'hours' ]) );
            }
            $em->persist( $calendar );

        }

        $em->flush();

        $view = View::create();
        $view->setData($event);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        return $view;

    }// "post_events"            [POST] /events

    /**
     * Delete a Event
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Delete a event",
     *   statusCodes = {
     *     204 = "OK"
     *   }
     * )
     *
     * @param $id
     *
     * @Rest\Delete("/events/{id}")
     * @Rest\View(statusCode=204)
     * @return array
     */
    public function deleteEventsAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('AppBundle:Event')->find($id);

        if ($event=== null)
        {
            return new View("Event ez da aurkitu", Response::HTTP_NOT_FOUND);
        }

        /** @var Calendar $calendar */
        $calendar = $event->getCalendar();

        /** @var Type $type */
        $type = $event->getType();
        if ( $type->getRelated() ) {
            /** @var Type $t */
            $t = $event->getType();
            if ( $t->getRelated() === "hours_free" ) {
                $calendar->setHoursFree( floatval( $calendar->getHoursFree() ) + $event->getHours() );
            }
            if ( $t->getRelated() === "hours_self" ) {
                $calendar->setHoursSelf( floatval( $calendar->getHoursSelf() ) + $event->getHours() );
            }
            if ( $t->getRelated() === "hours_compensed" ) {
                $calendar->setHoursCompensed( floatval( $calendar->getHoursCompensed() ) + $event->getHours() );
            }
            if ( $t->getRelated() === "hours_sindical" ) {
                $calendar->setHoursSindikal( floatval( $calendar->getHoursSindikal() ) + $event->getHours() );
            }
            $em->persist( $calendar );
        }

        $em->remove($event);
        $em->flush();
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