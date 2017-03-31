<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\User;
use AppBundle\Form\CalendarType;
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
class CalendarController extends Controller {

    /**
     * Lists all calendar entities.
     *
     * @Route("/", name="admin_calendar_index")
     * @Method("GET")
     */
    public function indexAction ()
    {
        $em = $this->getDoctrine()->getManager();

        $calendars = $em->getRepository('AppBundle:Calendar')->findAll();

        return $this->render(
            'calendar/index.html.twig',
            array(
                'calendars' => $calendars,
            )
        );
    }

    /**
     * Creates a new calendar entity.
     *
     * @Route("/new/{username}", name="admin_calendar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction (Request $request, $username = "")
    {
        $em       = $this->getDoctrine()->getManager();
        $year     = Date("Y");
        $calendar = new Calendar();
        $calendar->setYear($year);

        if ($username !== "") {
            $user = $em->getRepository('AppBundle:User')->findOneBy(
                array(
                    'username' => $username,
                )
            );
            $calendar->setUser($user);
        }
        $year = ( new DateTime )->format("Y");
        $calendar->setName($username.' - '.$year);
        $form = $this->createForm(
            CalendarType::class,
            $calendar,
            array(
                'action'   => $this->generateUrl('admin_calendar_new'),
                'method'   => 'POST',
                'username' => $username,
            )
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* Check if User exist in our app */
            $username = $form->get('username')->getData();

            $u = $em->getRepository('AppBundle:User')->getByUsername($username);

            if ( ! $u) {
                $userManager = $this->container->get('fos_user.user_manager');
                /** @var $user User */
                $user = $userManager->createUser();
                $user->setUsername($username);
                $user->setEmail($username.'@pasaia.net');
                $user->setPassword('');
                $user->setDn('');
                $user->setEnabled(true);
                $userManager->updateUser($user);
                $u = $user;
            }
            $calendar->setUser($u);
            $em->persist($calendar);
            $em->flush($calendar);

            return $this->redirectToRoute('admin_calendar_edit', array( 'id' => $calendar->getId() ));
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render(
                'calendar/_ajax_new.html.twig',
                array(
                    'calendar' => $calendar,
                    'username' => $username,
                    'form'     => $form->createView(),
                )
            );
        } else {
            return $this->render(
                'calendar/new.html.twig',
                array(
                    'calendar' => $calendar,
                    'username' => $username,
                    'form'     => $form->createView(),
                )
            );
        }


    }

    /**
     * Finds and displays a calendar entity.
     *
     * @Route("/{id}", name="admin_calendar_show")
     * @Method("GET")
     */
    public function showAction (Calendar $calendar)
    {
        $deleteForm = $this->createDeleteForm($calendar);

        return $this->render(
            'calendar/show.html.twig',
            array(
                'calendar'    => $calendar,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing calendar entity.
     *
     * @Route("/{id}/edit", name="admin_calendar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction (Request $request, Calendar $calendar=null)
    {
        if (empty($calendar)) {
            $this->addFlash('danger', "Ez da egutegia topatu");
            return $this->redirectToRoute('dashboard');
        }
        $deleteForm = $this->createDeleteForm($calendar);
        $editForm   = $this->createForm(
            CalendarType::class,
            $calendar,
            array(
                'action' => $this->generateUrl('admin_calendar_edit', array( 'id' => $calendar->getId() )),
                'method' => 'POST',
            )
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_calendar_edit', array( 'id' => $calendar->getId() ));
        }

        $em    = $this->getDoctrine()->getManager();
        $types = $em->getRepository('AppBundle:Type')->findAll();

        return $this->render(
            'calendar/edit.html.twig',
            array(
                'calendar'    => $calendar,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'types'       => $types,
            )
        );
    }

    /**
     * Deletes a calendar entity.
     *
     * @Route("/{id}", name="admin_calendar_delete")
     * @Method("DELETE")
     */
    public function deleteAction (Request $request, Calendar $calendar)
    {
        $form = $this->createDeleteForm($calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calendar);
            $em->flush();
        }

        return $this->redirectToRoute('admin_calendar_index');
    }

    /**
     * Creates a form to delete a calendar entity.
     *
     * @param Calendar $calendar The calendar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm (Calendar $calendar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_calendar_delete', array( 'id' => $calendar->getId() )))
            ->setMethod('DELETE')
            ->getForm();
    }
}
