<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Document;
use AppBundle\Entity\Event;
use AppBundle\Entity\File;
use AppBundle\Entity\Hour;
use AppBundle\Entity\Log;
use AppBundle\Entity\TemplateEvent;
use AppBundle\Entity\User;
use AppBundle\Form\CalendarNoteType;
use AppBundle\Form\CalendarType;
use AppBundle\Form\DocumentType;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Calendar controller.
 *
 * @Route("admin/calendar")
 */
class CalendarController extends Controller
{
    /**
     * Lists all calendar entities.
     *
     * @Route("/", name="admin_calendar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $calendars = $em->getRepository('AppBundle:Calendar')->findAll();

        return $this->render(
            'calendar/index.html.twig',
            [
                'calendars' => $calendars,
            ]
        );
    }

    /**
     * Creates a new calendar entity.
     *
     * @Route("/new/{username}", name="admin_calendar_new")
     * @Method({"GET", "POST"})
     *
     * @param mixed $username
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, $username = '')
    {
        $em = $this->getDoctrine()->getManager();
        $year = date('Y');
        $calendar = new Calendar();
        $calendar->setYear($year);

        if ($username !== '') {
            $user = $em->getRepository('AppBundle:User')->findOneBy(
                [
                    'username' => $username,
                ]
            );
            $calendar->setUser($user);
        }
        $year = ( new DateTime() )->format('Y');
        $calendar->setName($username.' - '.$year);
        $form = $this->createForm(
            CalendarType::class,
            $calendar,
            [
                'action' => $this->generateUrl('admin_calendar_new'),
                'method' => 'POST',
                'username' => $username,
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* Check if User exist in our app */
            $username = $form->get('username')->getData();

            $u = $em->getRepository('AppBundle:User')->getByUsername($username);

            if (!$u) {
                $ldap = $this->get('ldap_tools.ldap_manager');
                $ldapuser = $ldap->buildLdapQuery()
                    ->select(['name', 'guid', 'username', 'emailAddress', 'firstName', 'lastName', 'dn', 'department', 'description'])
                    ->fromUsers()
                    ->where($ldap->buildLdapQuery()->filter()->eq('username', $username))
                    ->orderBy('username')
                    ->getLdapQuery()
                    ->getSingleResult();

                $userManager = $this->container->get('fos_user.user_manager');
                /** @var $user User */
                $user = $userManager->createUser();
                $user->setUsername($username);
                $user->setEmail($username.'@pasaia.net');
                $user->setPassword('');
                if ($ldapuser->has('dn')) {
                    $user->setDn($ldapuser->getDn());
                }
                $user->setEnabled(true);
                if ($ldapuser->has('description')) {
                    $user->setLanpostua($ldapuser->getDescription());
                }
                if ($ldapuser->has('department')) {
                    $user->setDepartment($ldapuser->getDepartment());
                }

                $userManager->updateUser($user);
                $u = $user;
            }
            $calendar->setUser($u);
            $em->persist($calendar);

            /** @var Log $log */
            $log = new Log();
            $log->setName('Egutegia sortu');
            $log->setDescription($calendar->getName().' egutegia sortua izan da');
            $log->setCalendar($calendar);
            //$log->setUser( $this->getUser() );
            $em->persist($log);

            $em->flush($calendar);

            return $this->redirectToRoute('admin_calendar_edit', ['id' => $calendar->getId()]);
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render(
                'calendar/_ajax_new.html.twig',
                [
                    'calendar' => $calendar,
                    'username' => $username,
                    'form' => $form->createView(),
                ]
            );
        }

        return $this->render(
                'calendar/new.html.twig',
                [
                    'calendar' => $calendar,
                    'username' => $username,
                    'form' => $form->createView(),
                ]
            );
    }

    /**
     * Finds and displays a calendar entity.
     *
     * @Route("/{id}", name="admin_calendar_show")
     * @Method("GET")
     */
    public function showAction(Calendar $calendar)
    {
        $deleteForm = $this->createDeleteForm($calendar);

        return $this->render(
            'calendar/show.html.twig',
            [
                'calendar' => $calendar,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing calendar entity.
     *
     * @Route("/{id}/edit", name="admin_calendar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Calendar $calendar = null)
    {
        if (empty($calendar)) {
            $this->addFlash('danger', 'Ez da egutegia topatu');

            return $this->redirectToRoute('dashboard');
        }
        $deleteForm = $this->createDeleteForm($calendar);
        $editForm = $this->createForm(
            CalendarType::class,
            $calendar,
            [
                'action' => $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]),
                'method' => 'POST',
            ]
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_calendar_edit', ['id' => $calendar->getId()]);
        }

        $em = $this->getDoctrine()->getManager();

        $logs = $em->getRepository('AppBundle:Log')->findCalendarLogs($calendar->getId());

        $types = $em->getRepository('AppBundle:Type')->findAll();

        $frmnote = $this->createForm(
            CalendarNoteType::class,
            $calendar
        );

        $doc = new Document();
        $doc->setCalendar($calendar);
        $frmFile = $this->createForm(
            DocumentType::class,
            $doc
        );

        $documents = $calendar->getDocuments();
        $deleteDocumentForms = [];
        foreach ($documents as $doc) {
            $deleteDocumentForms[$doc->getId()] = $this->createDocumentDeleteForm($doc)->createView();
        }

        $hours = $calendar->getHours();
        $deleteHoursForms = [];
        foreach ($hours as $h) {
            $deleteHoursForms[$h->getId()] = $this->createHourDeleteForm($h)->createView();
        }


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
            'calendar/edit.html.twig',
            [
                'calendar' => $calendar,
                'orduak' => $calendar->getHours(),
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'frmnote' => $frmnote->createView(),
                'frmfile' => $frmFile->createView(),
                'logs' => $logs,
                'types' => $types,
                'deletedocumentforms' => $deleteDocumentForms,
                'deletehourforms' => $deleteHoursForms,
                'selfHoursPartial'=> $selfHoursPartial,
                'selfHoursComplete'=>$selfHoursComplete
            ]
        );
    }

    /**
     * Deletes a calendar entity.
     *
     * @Route("/{id}", name="admin_calendar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Calendar $calendar)
    {
        $form = $this->createDeleteForm($calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calendar);
            $em->flush();
        }

        return $this->redirectToRoute('dashboard');
    }

    /**
     * Creates a form to delete a calendar entity.
     *
     * @param Calendar $calendar The calendar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Calendar $calendar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_calendar_delete', ['id' => $calendar->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Creates a form to delete a calendar entity.
     *
     * @param Document $doc The calendar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDocumentDeleteForm(Document $doc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_document_delete', ['id' => $doc->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Creates a form to delete a Hour entity.
     *
     * @param Hour $h The calendar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createHourDeleteForm(Hour $h)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_hour_delete', ['id' => $h->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Compare calendars
     *
     * @Route("/compare", name="admin_calendar_compare")
     * @Method("post")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function compareAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $postdata = $request->get( 'users' );
        $usernames = explode( ",", $postdata );
        $calendars = [];
        $data =[];
        $events=[];
        $tevents = [];
        $colors = [ "#db6cb4", "#e01b1b", "#5c8f4f", "#e87416", "#484cd9" ];
        $index = -1;
        $calendarcolors = [];

        foreach ($usernames as $u) {
            $index +=1;
            /** @var Calendar $calendar */
            $calendar = $em->getRepository( 'AppBundle:Calendar' )->findByUsernameYear( $u, date( "Y" ) );
            if ( count($calendar) > 0) {
                /** @var Calendar $calendar */
                $calendar = $calendar[ 0 ];
                array_push( $calendars, $calendar->getId() );

                /** @var Event $event */
                $event = $calendar->getEvents();
                foreach ($event as $e) {
                    $temp=[];
                    /** @var Event $e */
                    //$temp[ "color" ] = $e->getType()->getColor();
                    $temp[ "color" ] = $colors[$index];
                    $temp[ "endDate" ] = $e->getEndDate()->format('Y-m-d');
                    $temp[ "hours" ] = $e->getHours();
                    $temp[ "id" ] = $e->getId();
                    $temp[ "template" ] = $calendar->getTemplate()->getId();
                    $temp[ "name" ] = $u . " => ".$e->getName();
                    $temp[ "startDate" ] = $e->getStartDate()->format('Y-m-d');;
                    $temp[ "type" ] = $e->getType()->getId();
                    array_push( $events, $temp );
                }

                ///** @var TemplateEvent $tevent */
                //$tevent = $calendar->getTemplate()->getTemplateEvents();
                //foreach ($tevent as $te) {
                //    $temp=[];
                //    /** @var TemplateEvent $te */
                //    //$temp[ "color" ] = $e->getType()->getColor();
                //    $temp[ "color" ] = $colors[$index];
                //    $temp[ "endDate" ] = $te->getEndDate()->format('Y-m-d');
                //    //$temp[ "hours" ] = $te->getHours();
                //    $temp[ "id" ] = $te->getId();
                //    $temp[ "template" ] = $te->getTemplate()->getId();
                //    $temp[ "name" ] = $te->getName();
                //    $temp[ "startDate" ] = $te->getStartDate()->format('Y-m-d');;
                //    $temp[ "type" ] = $te->getType()->getId();
                //    array_push( $events, $temp );
                //}

                array_push(
                    $calendarcolors,
                    array(
                        'username' => $u,
                        'color'    => $colors[ $index ],
                    )
                );


            }
        }

        return $this->render(
            'calendar/compare.html.twig',
            [
                'calendars' => implode(",", $calendars),
                'events' => $events,
                'calendarcolors' => $calendarcolors
            ]
        );
    }
}
