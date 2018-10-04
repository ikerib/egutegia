<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ApiBundle\Controller;

use AppBundle\Entity\Calendar;

use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Event;

use AppBundle\Entity\Firma;
use AppBundle\Entity\Firmadet;
use AppBundle\Entity\Log;

use AppBundle\Entity\Notification;
use AppBundle\Entity\Sinatzaileak;
use AppBundle\Entity\Sinatzaileakdet;
use AppBundle\Entity\TemplateEvent;
use AppBundle\Entity\Type;
use AppBundle\Entity\User;
use AppBundle\Form\CalendarNoteType;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class ApiController extends FOSRestController
{

    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** TEMPLATE ****** ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/

    /**
     * Get template Info.
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
     *
     * @return \AppBundle\Entity\Template|array|View|object
     * @Annotations\View()
     * @Get("/template/{id}")
     */

    public function getTemplateAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $template = $em->getRepository( 'AppBundle:Template' )->find( $id );

        if ( $template === null ) {
            return new View( 'there are no users exist', Response::HTTP_NOT_FOUND );
        }

        return $template;
    }

    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** TEMPLATE EVENTS ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/

    /**
     * Get template Events.
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
     *
     * @return array|View
     * @Annotations\View()
     * @Get("/templateevents/{templateid}")
     */
    public function getTemplateEventsAction( $templateid )
    {
        $em = $this->getDoctrine()->getManager();

        $tevents = $em->getRepository( 'AppBundle:TemplateEvent' )->getTemplateEvents( $templateid );

        if ( $tevents === null ) {
            return new View( 'there are no users exist', Response::HTTP_NOT_FOUND );
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
     * @Annotations\View()
     *
     * @param Request $request
     *
     * @return View
     */
    public function postTemplateEventsAction( Request $request ): View
    {
        $em = $this->getDoctrine()->getManager();

        $jsonData = json_decode( $request->getContent(), true );

        // bilatu egutegia
        $template = $em->getRepository( 'AppBundle:Template' )->find( $jsonData[ 'templateid' ] );

        // bilatu egutegia
        $type = $em->getRepository( 'AppBundle:Type' )->find( $jsonData[ 'type' ] );

        /** @var TemplateEvent $templateevent */
        $templateevent = new TemplateEvent();
        $templateevent->setTemplate( $template );
        $templateevent->setType( $type );
        $templateevent->setName( $jsonData[ 'name' ] );
        $tempini = new \DateTime( $jsonData[ 'startDate' ] );
        $templateevent->setStartDate( $tempini );
        $tempfin = new \DateTime( $jsonData[ 'endDate' ] );
        $templateevent->setEndDate( $tempfin );

        $em->persist( $templateevent );
        $em->flush();

        $view = View::create();
        $view->setData( $templateevent );
        header( 'content-type: application/json; charset=utf-8' );
        header( 'access-control-allow-origin: *' );

        return $view;
    } // "post_templateevents"            [POST] /templateevents

    /**
     * Delete template Events.
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
     *
     * @return View
     */

    public function deleteTemplateEventsAction( $templateid ): ?View
    {
        $em = $this->getDoctrine()->getManager();

        $template = $em->getRepository( 'AppBundle:Template' )->find( $templateid );

        if ( $template === null ) {
            return new View( 'there are no Template events exist', Response::HTTP_NOT_FOUND );
        }

        $tevents = $template->getTemplateEvents();
        foreach ( $tevents as $t ) {
            $em->remove( $t );
        }
        $em->flush();
    }

    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** CALENDAR EVENTS ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/

    /**
     * Get calendar Events.
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
     *
     * @return array|View
     * @Annotations\View()
     */

    public function getEventsAction( $calendarid )
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository( 'AppBundle:Event' )->getEvents( $calendarid );

        if ( $events === null ) {
            return new View( 'there are no users exist', Response::HTTP_NOT_FOUND );
        }

        return $events;
    }

    /**
     * Update a Event.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Update a Event",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param Request $request
     * @param         $id
     *
     * @return View
     * @throws EntityNotFoundException
     * @Rest\View(statusCode=200)
     * @Rest\Put("/events/{id}")
     */

    public function putEventAction( Request $request, $id ): View
    {
        $em = $this->getDoctrine()->getManager();

        $jsonData = json_decode( $request->getContent(), true );

        // find event
        $event = $em->getRepository( 'AppBundle:Event' )->find( $id );
        if ( !$event ) {
            throw new EntityNotFoundException('Ez da topatu');
        }

        // find calendar
        /** @var Calendar $calendar */
        $calendar = $em->getRepository( 'AppBundle:Calendar' )->find( $jsonData[ 'calendarid' ] );

        // find type
        /** @var Type $type */
        $type = $em->getRepository( 'AppBundle:Type' )->find( $jsonData[ 'type' ] );

        $event->setName( $jsonData[ 'name' ] );
        $tempini = new \DateTime( $jsonData[ 'startDate' ] );
        $event->setStartDate( $tempini );
        $tempfin = new \DateTime( $jsonData[ 'endDate' ] );
        $event->setEndDate( $tempfin );
        $event->setHours( $jsonData[ 'hours' ] );

        $event->setType( $type );
        $em->persist( $event );

        $oldValue = (float)$jsonData[ 'oldValue' ];
        $newValue = (float)$jsonData[ 'hours' ];

        $oldType = $jsonData[ 'oldType' ];
        $hours   = (float)$event->getHours() - $oldValue;

        if ( $type->getRelated() ) {
            if ( $type->getId() === (int)$oldType ) { // Mota berdinekoak badira, zuzenketa
                /** @var Type $t */
                $t = $event->getType();
                if ( $t->getRelated() === 'hours_free' ) {
                    $calendar->setHoursFree( (float)$calendar->getHoursFree() + $hours );
                }
                if ( $t->getRelated() === 'hours_self' ) {
                    if ( $oldValue > 0 ) {
                        if ( $oldValue < (float)$calendar->getHoursDay() ) {
                            $calendar->setHoursSelfHalf( (float)$calendar->getHoursSelfHalf() - $hours );
                        } else {
                            $calendar->setHoursSelf( (float)$calendar->getHoursSelf() - $hours );
                        }
                    }
                    //$calendar->setHoursSelf((float) ($calendar->getHoursSelf()) + $hours);
                }

                if ( $t->getRelated() === 'hours_compensed' ) {
                    $calendar->setHoursCompensed(
                        (float)( $calendar->getHoursCompensed() ) + (float)$oldValue - (float)$event->getHours()
                    );
                }
                if ( $t->getRelated() === 'hours_sindical' ) {
                    $calendar->setHoursSindikal( (float)( $calendar->getHoursSindikal() ) + $hours );
                }
                $em->persist( $calendar );
            } else { // Mota ezberdinekoak dira, aurrena aurreko motan gehitu, mota berrian kentu ondoren
                /** @vat Type $tOld */
                $tOld = $em->getRepository( 'AppBundle:Type' )->find( $oldType );
                if ( $tOld->getRelated() === 'hours_free' ) {
                    $calendar->setHoursFree( (float)( $calendar->getHoursFree() ) + $oldValue );
                }
                if ( $tOld->getRelated() === 'hours_self' ) {
                    if ( $oldValue > 0 ) {
                        if ( $oldValue < (float)$calendar->getHoursDay() ) {
                            $calendar->setHoursSelfHalf( (float)$calendar->getHoursSelfHalf() + $oldValue );
                        } else {
                            $calendar->setHoursSelf( (float)$calendar->getHoursSelf() + $oldValue );
                        }
                    }
                }
                if ( $tOld->getRelated() === 'hours_compensed' ) {
                    $calendar->setHoursCompensed( (float)( $calendar->getHoursCompensed() ) + $oldValue );
                }
                if ( $tOld->getRelated() === 'hours_sindical' ) {
                    $calendar->setHoursSindikal( (float)( $calendar->getHoursSindikal() ) + $oldValue );
                }

                /** @var Type $tNew */
                $tNew = $event->getType(); // Mota berria
                if ( $tNew->getRelated() === 'hours_free' ) {
                    $calendar->setHoursFree( (float)( $calendar->getHoursFree() ) - $newValue );
                }
                if ( $tNew->getRelated() === 'hours_self' ) {
                    if ( $oldValue > 0 ) {
                        if ( $oldValue < (float)$calendar->getHoursDay() ) {
                            $calendar->setHoursSelfHalf( (float)$calendar->getHoursSelfHalf() - $newValue );
                        } else {
                            $calendar->setHoursSelf( (float)$calendar->getHoursSelf() - $newValue );
                        }
                    }
                }
                if ( $tNew->getRelated() === 'hours_compensed' ) {
                    $calendar->setHoursCompensed( (float)( $calendar->getHoursCompensed() ) - $newValue );
                }
                if ( $tNew->getRelated() === 'hours_sindical' ) {
                    $calendar->setHoursSindikal( (float)( $calendar->getHoursSindikal() ) - $newValue );
                }

                $em->persist( $calendar );
            }

            /** @var Log $log */
            $log = new Log();
            $log->setName( 'Egutegiko egun bat eguneratua izan da' );
            $log->setCalendar( $calendar );
            $log->setDescription( $event->getName() . ' ' . $event->getHours() . ' ordu ' . $event->getType() );
            $em->persist( $log );
        }
        $em->flush();

        $view = View::create();
        $view->setData( $event );
        header( 'content-type: application/json; charset=utf-8' );
        header( 'access-control-allow-origin: *' );

        return $view;
    } // "put_event"             [PUT] /events/{id}

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
     * @var Request
     * @Annotations\View()
     *
     * @return View
     */

    public function postEventsAction( Request $request )
    {
        $em       = $this->getDoctrine()->getManager();
        $jsonData = json_decode( $request->getContent(), true );

        // find calendar
        /** @var Calendar $calendar */

        $calendar = $em->getRepository( 'AppBundle:Calendar' )->find( $jsonData[ 'calendarid' ] );

        // find type
        /** @var Type $type */
        $type = $em->getRepository( 'AppBundle:Type' )->find( $jsonData[ 'type' ] );

        /** @var Event $event */
        $event = new Event();
        $event->setCalendar( $calendar );
        $event->setName( $jsonData[ 'name' ] );
        $tempini = new \DateTime( $jsonData[ 'startDate' ] );
        $event->setStartDate( $tempini );
        $tempfin = new \DateTime( $jsonData[ 'endDate' ] );
        $event->setEndDate( $tempfin );
        $event->setHours( $jsonData[ 'hours' ] );
        $event->setType( $type );

        if ( $type->getId() == 5 ) {  // TODO: Norbere arazoetarako
            $event->setNondik( $jsonData[ "egunorduak" ] );
            $event->setHoursSelfBefore( $jsonData[ "HoursSelfBefore" ] );
            $event->setHoursSelfHalfBefore( $jsonData[ "HoursSelfHalfBefore" ] );
        }

        $em->persist( $event );

        if ( $type->getRelated() ) {
            /** @var Type $t */
            $t = $event->getType();
            if ( $t->getRelated() === 'hours_free' ) {
                $calendar->setHoursFree( (float)( $calendar->getHoursFree() ) - (float)( $jsonData[ 'hours' ] ) );
            }
            if ( $t->getRelated() === 'hours_self' ) {

                /**
                 * 1-. Begiratu eskatuta orduak jornada bat baino gehiago direla edo berdin,
                 * horrela bada hours_self-etik kendu bestela ordueta hours_self_half
                 */
                $jornada = floatval( $calendar->getHoursDay() );
                $orduak  = floatval( $jsonData[ 'hours' ] );
                $nondik  = $jsonData[ 'egunorduak' ];

                $partziala           = 0;
                $egunOsoaOrduak      = 0;
                $egutegiaOrduakTotal = floatval( $calendar->getHoursSelf() ) + floatval( $calendar->getHoursSelfHalf() );


                if ( $nondik == "orduak" ) {
                    // Begiratu nahiko ordu dituen
                    if ( $calendar->getHoursSelfHalf() >= $orduak ) {
                        $partziala = $calendar->getHoursSelfHalf();
                    } else {
                        $view    = View::create();
                        $errorea = array( "Result" => "Ez ditu nahikoa ordu" );
                        $view->setData( $errorea );
                        header( 'content-type: application/json; charset=utf-8' );
                        header( 'access-control-allow-origin: *' );

                        return $view;
                    }

                } else {
                    // Begiratu nahiko ordu dituen Egunetan
                    // Eskatutako ordu adina edo gehiago baditu
                    if ( $calendar->getHoursSelf() >= $orduak ) {
                        $egunOsoaOrduak = $orduak;
                    } else if ( $egutegiaOrduakTotal >= $orduak ) {
                        $zenbatEgun = $orduak / $jornada;
                        // Egun osoen kenketa
                        $egunOsoak = (int)$zenbatEgun;
                        // Orduen kenketa
                        $gainontzekoa = $zenbatEgun - (int)$zenbatEgun;

                        $egunOsoaOrduak = $egunOsoak * $jornada;
                        $partziala      = $gainontzekoa * $jornada;
                    }
                }

                $calendar->setHoursSelf( $calendar->getHoursSelf() - $egunOsoaOrduak );
                $calendar->setHoursSelfHalf( $calendar->getHoursSelfHalf() - $partziala );
            }
            if ( $t->getRelated() === 'hours_compensed' ) {
                $calendar->setHoursCompensed(
                    (float)( $calendar->getHoursCompensed() ) - (float)( $jsonData[ 'hours' ] )
                );
            }
            if ( $t->getRelated() === 'hours_sindical' ) {
                $calendar->setHoursSindikal(
                    (float)( $calendar->getHoursSindikal() ) - (float)( $jsonData[ 'hours' ] )
                );
            }
            $em->persist( $calendar );
        }

        $em->flush();

        $view = View::create();
        $view->setData( $event );
        header( 'content-type: application/json; charset=utf-8' );
        header( 'access-control-allow-origin: *' );

        return $view;
    } // "post_events"            [POST] /events

    /**
     * Delete a Event.
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
     *
     * @return View
     */

    public function deleteEventsAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository( 'AppBundle:Event' )->find( $id );

        if ( $event === null ) {
            return new View( 'Event ez da aurkitu', Response::HTTP_NOT_FOUND );
        }

        /** @var Calendar $calendar */
        $calendar = $event->getCalendar();

        /** @var Type $type */
        $type = $event->getType();
        if ( $type->getRelated() ) {
            /** @var Type $t */
            $t = $event->getType();
            if ( $t->getRelated() === 'hours_free' ) {
                $calendar->setHoursFree( (float)( $calendar->getHoursFree() ) + $event->getHours() );
            }
            if ( $t->getRelated() === 'hours_self' ) {

                /* Maiatzean (2018) Event entitarean sortu aurretik zuten balioak gordetzen hasi nintzen
                   ezabatzen denean, datu horiek berreskuratu ahal izateko. Baina aurretik grabatutako datuetan... kalkuluak egin behar
                 */
                if ( !is_null($event->getNondik())  ) {  // Aurreko egoerako datuak grabatuak daude, iuju!
                    if ( $event->getNondik() == "Egunak" ) {
                        $calendar->setHoursSelf( floatval($calendar->getHoursSelf()) + floatval($event->getHours()) );
                    }else {
                        $calendar->setHoursSelfHalf( floatval($calendar->getHoursSelfHalf()) + floatval($event->getHours()) );
                    }
                } else { // Kalkuluak egin behar. 2019rako egutegirako datorren elseko kodea ezaba daiteke, event guztiek izango bait dituzte datuak
                    $jornada = floatval( $calendar->getHoursDay() );
                    $orduak  = floatval( $event->getHours() );
                    if ( $orduak < $jornada ) {
                        $osoa      = $orduak;
                        $partziala = $orduak;
                    } else {
                        $zenbatEgun = $orduak / $jornada;

                        $orduOsoak = $jornada * $zenbatEgun;
                        $osoa      = $orduak;
                        $partziala = $orduak - $orduOsoak;
                    }
                    $calendar->setHoursSelf( floatval($calendar->getHoursSelf()) + floatval($osoa) * -1 );
                    $calendar->setHoursSelfHalf( floatval($calendar->getHoursSelfHalf()) + floatval($partziala) * -1 );
                }

            }
            if ( $t->getRelated() === 'hours_compensed' ) {
                $calendar->setHoursCompensed( (float)( $calendar->getHoursCompensed() ) + $event->getHours() );
            }
            if ( $t->getRelated() === 'hours_sindical' ) {
                $calendar->setHoursSindikal( (float)( $calendar->getHoursSindikal() ) + $event->getHours() );
            }
            $em->persist( $calendar );
        }

        $em->remove( $event );
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
     * @return View
     * @throws HttpException
     *
     */
    public function postNotesAction( Request $request, $calendarid )
    {
        $em = $this->getDoctrine()->getManager();

        $calendar = $em->getRepository( 'AppBundle:Calendar' )->find( $calendarid );

        $frmnote = $this->createForm(
            CalendarNoteType::class,
            $calendar
        );
        $frmnote->handleRequest( $request );
        if ( $frmnote->isValid() ) {
            $em->persist( $calendar );

            /** @var Log $log */
            $log = new Log();
            $log->setName( 'Egutegiaren oharrak eguneratuak' );
            $log->setDescription( 'Testua eguneratua' );
            $em->persist( $log );
            $em->flush();

            $view = View::create();
            $view->setData( $calendar );

            header( 'content-type: application/json; charset=utf-8' );
            header( 'access-control-allow-origin: *' );

            return $view;
        }
        throw new HttpException( 400, 'ez da topatu.' );
    } // "post_notes"            [POST] /notes/{calendarid}

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
     * @return View
     * @throws \LdapTools\Exception\EmptyResultException
     * @throws \LdapTools\Exception\MultiResultException
     * @Annotations\View()
     */

    public function postUsernotesAction( Request $request, $username )
    {
        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository( 'AppBundle:User' )->getByUsername( $username );

        $jsonData = json_decode( $request->getContent(), true );

        $userManager = $this->container->get( 'fos_user.user_manager' );

        if ( !$user ) {
            $ldap     = $this->get( 'ldap_tools.ldap_manager' );
            $ldapuser = $ldap->buildLdapQuery()
                             ->select(
                                 [
                                     'name',
                                     'guid',
                                     'username',
                                     'emailAddress',
                                     'firstName',
                                     'lastName',
                                     'dn',
                                     'department',
                                     'description',
                                 ]
                             )
                             ->fromUsers()
                             ->where( $ldap->buildLdapQuery()->filter()->eq( 'username', $username ) )
                             ->orderBy( 'username' )
                             ->getLdapQuery()
                             ->getSingleResult();


            /** @var $user User */
            $user = $userManager->createUser();
            $user->setUsername( $username );
            $user->setEmail( $username . '@pasaia.net' );
            $user->setPassword( '' );
            if ( $ldapuser->has( 'dn' ) ) {
                $user->setDn( $ldapuser->getDn() );
            }
            $user->setEnabled( true );
            if ( $ldapuser->has( 'description' ) ) {
                $user->setLanpostua( $ldapuser->getDescription() );
            }
            if ( $ldapuser->has( 'department' ) ) {
                $user->setDepartment( $ldapuser->getDepartment() );
            }
        }

        $user->setNotes( $jsonData[ 'notes' ] );

        $userManager->updateUser( $user );

        $view = View::create();
        $view->setData( $user );

        header( 'content-type: application/json; charset=utf-8' );
        header( 'access-control-allow-origin: *' );

        return $view;
    } // "post_usernotes"            [POST] /usernotes/{userid}


    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** ESKAERA API     ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/

    /**
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Postit funtzioa",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param Request $request
     * @param         $id
     * @param         $userid
     *
     *
     * @return View
     * @throws EntityNotFoundException
     * @Rest\View(statusCode=200)
     * @Rest\Put("/postit/{id}/{userid}")
     */
    public function putPostitAction(Request $request, $id, $userid): View
    {
        /**
         * OHARRA: PUT_FIRMA MODIFIKATZEN BADA, PUT_POSTIT MODIFIKATU BEHAR DA ETA ALDERANTZIZ
         */
        $em = $this->getDoctrine()->getManager();

        $jsonData = json_decode( $request->getContent(), true );
        $onartua  = false;
        $oharrak  = $request->request->get( 'oharra' );
        if (( $request->request->get('onartua') === "1" ) || ($request->request->get('onartua') === 1 )){
            $onartua = true;
        }

        // find eskaera
        $firma = $em->getRepository( 'AppBundle:Firma' )->find( $id );
        if ( !$firma ) {
            throw new EntityNotFoundException('Ez da topatu');
        }

        /** @var User $user */
        $user = $em->getRepository( 'AppBundle:User' )->find( $userid );


//        if ( $firma->getCompleted() === false ) {


            /**
             * 1-. Firmatzen badu begiratu ea firma guztiak dituen, ala badu complete=true jarri
             *      Ez badu firmatu, firmatu eta begiratu eta complete jarri behar duen
             */

            //Firmatu
            /** @var Firmadet $firmadets */
            $firmadets = $firma->getFirmadet();
            /** @var Firmadet $fd */
            foreach ( $firmadets as $fd ) {
                /** @var Sinatzaileakdet $sd */
                $sd = $fd->getSinatzaileakdet();

                /** @var User $su */
                $su = $sd->getUser();

                if ( $user->getId() === $su->getId() ) {
                    $fd->setFirmatua( true );
                    $fd->setFirmatzailea( $user );
                    $fd->setNoiz( New \DateTime() );
                    $em->persist( $fd );
                    $em->flush();
                    break;
                }
            }


            /** @var Eskaera $eskaera */
            $eskaera = $firma->getEskaera();


            // Oharrak grabatu
            if ('' === $eskaera->getOharra()) {
                $eskaera->setOharra($oharrak);
            } else {
                $eskaera->setOharra( $eskaera->getOharra() .'   '. $oharrak );
            }

            $em->persist( $eskaera );


            $zenbatFirmaFaltaDira = $em->getRepository( 'AppBundle:Firma' )->checkFirmaComplete( $firma->getId() );

            if ( \count( $zenbatFirmaFaltaDira ) === 0 ) { // firma guztiak lortu dira
                $firma->setCompleted( true );
            } else {
                $firma->setCompleted( false );
            }
            $em->persist( $firma );

            /**
             * 2-. firma guztiak baditu, orduan eskaera onartzen da erabat.
             */
            if ( $firma->getCompleted() === true ) {
                /** @var Eskaera $eskaera */
                $eskaera = $firma->getEskaera();
                $eskaera->setAmaitua( true );
                $em->persist( $eskaera );

                $bideratzaileakfind = $em->getRepository( 'AppBundle:User' )->findByRole( 'ROLE_BIDERATZAILEA' );
                $bideratzaileak     = [];
                /** @var User $b */
                foreach ( $bideratzaileakfind as $b ) {

                    $bideratzaileak[] = $b->getEmail();
                }
                $bailtzailea = $this->container->getParameter( 'mailer_bidaltzailea' );

                $message = ( new \Swift_Message( '[Egutegia][Janirazpen berria][Onartua] :' . $eskaera->getUser()->getDisplayname() ) )
                    ->setFrom( $bailtzailea )
                    ->setTo( $bideratzaileak )
                    ->setBody(
                        $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                            'Emails/eskaera_onartua.html.twig',
                            array( 'eskaera' => $eskaera )
                        ),
                        'text/html'
                    );

                $this->get( 'mailer' )->send( $message );

            }
//        }
        $em->flush();

        $view = View::create();
        $view->setData( $firma );
        header( 'content-type: application/json; charset=utf-8' );
        header( 'access-control-allow-origin: *' );


        return $view;
    }

    /**
     * Firmatu.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Firmatu eskaera",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param Request $request
     * @param         $id
     *
     *
     * @return View
     * @throws EntityNotFoundException
     * @Rest\View(statusCode=200)
     * @Rest\Put("/firma/{id}")
     */
    public function putFirmaAction( Request $request, $id ): View
    {
        /**
         * OHARRA: PUT_FIRMA MODIFIKATZEN BADA, PUT_POSTIT MODIFIKATU BEHAR DA ETA ALDERANTZIZ
         */
        $em = $this->getDoctrine()->getManager();

        $jsonData = json_decode( $request->getContent(), true );
        $onartua  = false;
        $oharrak  = $request->request->get('oharra');
        if (( $request->request->get('onartua') === "1" ) || ($request->request->get('onartua') === 1 )){
            $onartua = true;
        }

        // find eskaera
        $firma = $em->getRepository( 'AppBundle:Firma' )->find( $id );
        if ( !$firma ) {
            throw new EntityNotFoundException('Ez da topatu');
        }

        /** @var User $user */
        $user = $this->getUser();



        /**
         * 1-. Firmatzen badu begiratu ea firma guztiak dituen, ala badu complete=true jarri
         *      Ez badu firmatu, firmatu eta begiratu eta complete jarri behar duen
         */

        $unekoSinatzailea =null; // nork sinatzen duen momentu honetan
        //Firmatu
        /** @var Firmadet $firmadets */
        $firmadets = $firma->getFirmadet();
        /** @var Firmadet $fd */
        foreach ( $firmadets as $fd ) {
            /** @var Sinatzaileakdet $sd */
            $sd = $fd->getSinatzaileakdet();

            /** @var User $su */
            $su = $sd->getUser();

            if ( $user->getId() === $su->getId() ) {
                $fd->setFirmatua( $onartua );
                $fd->setFirmatzailea( $user );
                $fd->setNoiz( New \DateTime() );
                $em->persist( $fd );
                $em->flush();
                $unekoSinatzailea = $su;
                break;
            }
        }


        /** @var Eskaera $eskaera */
        $eskaera = $firma->getEskaera();


        // Oharrak grabatu
        $eskaera->setOharra( $oharrak );
        $em->persist( $eskaera );


        $zenbatFirmaFaltaDira = $em->getRepository( 'AppBundle:Firma' )->checkFirmaComplete( $firma->getId() );

        if ( \count( $zenbatFirmaFaltaDira ) === 0 ) { // firma guztiak lortu dira
            $firma->setCompleted( true );
        } else {
            $firma->setCompleted( false );
        }
        $em->persist( $firma );

        /**
         * 2-. firma guztiak baditu, orduan eskaera onartzen da erabat.
         */
        if ( $firma->getCompleted() === true ) {
            /** @var Eskaera $eskaera */
            $eskaera = $firma->getEskaera();
            $eskaera->setAmaitua( true );
            $em->persist( $eskaera );

            $bideratzaileakfind = $em->getRepository( 'AppBundle:User' )->findByRole( 'ROLE_BIDERATZAILEA' );
            $bideratzaileak     = [];
            /** @var User $b */
            foreach ( $bideratzaileakfind as $b ) {

                $bideratzaileak[] = $b->getEmail();
            }
            $bailtzailea = $this->container->getParameter( 'mailer_bidaltzailea' );

            $message = ( new \Swift_Message( '[Egutegia][Janirazpen berria][Onartua] :' . $eskaera->getUser()->getDisplayname() ) )
                ->setFrom( $bailtzailea )
                ->setTo( $bideratzaileak )
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/eskaera_onartua.html.twig',
                        array( 'eskaera' => $eskaera )
                    ),
                    'text/html'
                );

            $this->get( 'mailer' )->send( $message );

        } else {
            $hurrengoSinatzailea = null;
            // Firmak falta dituenez, Sinatzaile zerrengako hurrengoari jakinarazpena bidali

            $sinatzaileusers = $em->getRepository('AppBundle:Sinatzaileakdet')->findAllByIdSorted($firma->getSinatzaileak()->getId());
            $length = \count($sinatzaileusers);
            for($i = 0; $i < $length - 1; ++$i) {
                if ($unekoSinatzailea->getId() === $sinatzaileusers[$i]->getUser()->getId()) {
                    if ($i + 1 <= $length) {
                        $hurrengoSinatzailea = $sinatzaileusers[$i+1]->getUser();
                    }
                }
            }
            if ($hurrengoSinatzailea !== null) {
                $notify = New Notification();
                $notify->setName('Eskaera berria sinatzeke: '.$eskaera->getUser()->getDisplayname());

                $desc = $eskaera->getUser()->getDisplayname()." langilearen eskaera berria daukazu sinatzeke.\n".
                    'Egutegia: '.$eskaera->getCalendar()->getName().'\n'.
                    'Hasi: '.$eskaera->getHasi()->format('Y-m-d').'\n';

                if ($eskaera->getAmaitu() !== null) {
                    $desc .= 'Amaitu: '.$eskaera->getAmaitu()->format('Y-m-d');
                }

                $notify->setDescription($desc);
                $notify->setEskaera($eskaera);
                $notify->setFirma($firma);
                $notify->setReaded(false);
                $notify->setUser($hurrengoSinatzailea);
                $em->persist($notify);
            }
        }

        $em->flush();

        $view = View::create();
        $view->setData( $firma );
        header( 'content-type: application/json; charset=utf-8' );
        header( 'access-control-allow-origin: *' );


        return $view;
    }

    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** JAKINARAZPENA API     ********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /**
     * Jakinarazpena irakurria/irakurri gabe gisa markatu
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Jakinarazpena irakurria / irakurri gabe gisa markatu",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param Request $request
     * @param         $id
     *
     * @return View
     * @throws EntityNotFoundException
     * @Rest\View(statusCode=200)
     * @Rest\Put("/jakinarazpenareaded/{id}")
     */
    public function putJakinarazpenaReadedAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();

        $jsonData = json_decode( $request->getContent(), true );

        // find jakinarazpena
        $notify = $em->getRepository( 'AppBundle:Notification' )->find( $id );
        if ( !$notify ) {
            throw new EntityNotFoundException();
        }

        if ( $notify->getReaded() == false ) {
            $notify->setReaded( true );
        } else {
            $notify->setReaded( false );
        }
        $em->persist( $notify );


        $em->flush();

        $view = View::create();
        $view->setData( $notify );
        header( 'content-type: application/json; charset=utf-8' );
        header( 'access-control-allow-origin: *' );

        return $view;
    } // "put_jakinarazpena_readed"             [PUT] /jakinarazpenareaded/{id}


    /**
     * Jakinarazpena irakurria eta erantzuna markatu.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Onartu / Ez onartu eskaera",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @param Request $request
     * @param         $id
     *
     * @return View
     * @throws EntityNotFoundException
     * @Rest\View(statusCode=200)
     * @Rest\Put("/jakinarazpena/{id}")
     */
    public function putJakinarazpenaAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();

        $jsonData = json_decode( $request->getContent(), true );
        $onartua  = false;
        if (( $request->request->get('onartua') === "1" ) || ($request->request->get('onartua') === 1 )){
            $onartua = true;
        }

        // find jakinarazpena
        $notify = $em->getRepository( 'AppBundle:Notification' )->find( $id );
        if ( !$notify ) {
            throw new EntityNotFoundException();
        }

        $user = $this->getUser();

        //1-. Eskaera lortu
        /** @var Eskaera $eskaera */
        $eskaera = $notify->getEskaera();
        /** @var Sinatzaileak $sinatzaileak */
        $sinatzaileak = $eskaera->getSinatzaileak();
        //2-. Eskuratu firma
        /** @var Firma $firma */
        $firma = $eskaera->getFirma();

        //3-. Sinatzaileetan bilatu user
        $aldezaurretikFirmatua = false;
        /** @var Firmadet $fd */
        foreach ( $firma->getFirmadet() as $fd ) {
            //4-. Begiratu ez dagoela aldez aurretik firmatua
            if ( $fd->getFirmatzailea() ) {
                if ( $fd->getFirmatzailea() == $user ) {
                    $aldezaurretikFirmatua = true;
                }
            }
        }
        if ( $aldezaurretikFirmatua == false ) {
            /** @var Firmadet $fd */
            $fd = new Firmadet();
            $fd->setFirma( $firma );
            $fd->setFirmatua( true );
            $fd->setFirmatzailea( $user );
            $em->persist( $fd );
        }

        $notify->setReaded( true );
        $notify->setCompleted( true );
        $notify->setResult( $onartua );
        $em->persist( $notify );
        $em->flush();


        $view = View::create();
        $view->setData( $notify );
        header( 'content-type: application/json; charset=utf-8' );
        header( 'access-control-allow-origin: *' );

        return $view;
    } // "put_jakinarazpena"             [PUT] /jakinarazpena/{id}

    /******************************************************************************************************************/
    /******************************************************************************************************************/
    /***** FIRMADET API ***********************************************************************************************/
    /******************************************************************************************************************/
    /******************************************************************************************************************/

    /**
     * Get firmadet of a eskaera.
     *
     * @param $eskaeraid
     *
     * @return array|View
     * @Annotations\View()
     */
    public function getFirmatzaileakAction( $eskaeraid )
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Firmadet $fd */
        $fd = $em->getRepository( 'AppBundle:Firmadet' )->getFirmatzaileak( $eskaeraid );

        if ( $fd === null ) {
            return new View( 'there are no users exist', Response::HTTP_NOT_FOUND );
        }

        /** @var Eskaera $eskaera */
        $eskaera = $em->getRepository( 'AppBundle:Eskaera' )->find( $eskaeraid );
        /** @var Firma $firma */
        $firma = $eskaera->getFirma();

        if (!$firma) {
            return $this->view(null, 404);
        }
        /** @var Notification $notify */
        $notify = $em->getRepository( 'AppBundle:Notification' )->getNotificationForFirma( $firma->getId() );


        $users = [];
        /** @var Firmadet $f */
        foreach ( $fd as $f ) {
            $user = $f->getSinatzaileakdet()->getUser();


            $r = array(
                'user'      => $user,
                'notify'    => $notify,
                'postit'    => $f->getPostit(),
                'autofirma' => $f->getAutofirma(),
                'firmaid'   => $firma->getId(),
                'firmatua'  => $f->getFirmatua(),
            );

            $users[] = $r;
        }


        return $users;
    }// "get_firmatzaileak"             [GET] /firmatzaileak/{eskaeraid}

    /**
     * Get firmadet of a Jakinarazèma.
     *
     *
     * @param $jakinarazpenaid
     *
     * @return array|View
     * @Annotations\View()
     */
    public function getFirmatzaileakfromjakinarazpenaAction( $jakinarazpenaid )
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Notification $jak */
        $jak = $em->getRepository( 'AppBundle:Notification' )->find( $jakinarazpenaid );

        /** @var Firmadet $fd */
        $fd = $em->getRepository( 'AppBundle:Firmadet' )->getFirmatzaileak( $jak->getEskaera()->getId() );

        if ( $fd === null ) {
            return new View( 'there are no users exist', Response::HTTP_NOT_FOUND );
        }

        /** Soilik User-ak behar ditugu */
        $users = [];
        /** @var Firmadet $f */
        foreach ( $fd as $f ) {
            $user = $f->getSinatzaileakdet()->getUser();
            $r    = array(
                'user'     => $user,
                'firmatua' => $f->getFirmatua(),
            );

            $users[] = $r;
        }


        return $users;
    }// "get_firmatzaileakfromjakinarazpena"             [GET] /firmatzaileakfromjakinarazpena/{jakinarazpenaid}
}
