<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Hour;
use AppBundle\Entity\Log;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\HourType;

/**
 * Hour controller.
 *
 * @Route("admin/hour")
 */
class HourController extends Controller
{
    /**
     * Lists all hour entities.
     *
     * @Route("/", name="admin_hour_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $hours = $em->getRepository('AppBundle:Hour')->findAll();

        return $this->render('hour/index.html.twig', [
            'hours' => $hours,
        ]);
    }

    /**
     * Creates a new hour entity.
     *
     * @Route("/new/{calendarid}", name="admin_hour_new", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param         $calendarid
     *
     * @return RedirectResponse|Response
     *@throws EntityNotFoundException
     *
     */
    public function newAction(Request $request, $calendarid)
    {
        $em = $this->getDoctrine()->getManager();
        $calendar = $em->getRepository('AppBundle:Calendar')->find($calendarid);

        if (!$calendar) {
            throw new EntityNotFoundException('ez da topatu egutegia');
        }

        $hour = new Hour();
        $hour->setFactor(1.75);
        $hour->setCalendar($calendar);

        $form = $this->createForm(
            HourType::class,
            $hour,
            [
            'action' => $this->generateUrl('admin_hour_new', ['calendarid' => $calendarid]),
            'method' => 'POST',
        ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $data = $form->getData();
            $calendar->setHoursCompensed($calendar->getHoursCompensed() + $data->getTotal());

            /** @var Log $log */
            $log = new Log();
            $log->setCalendar($calendar);
            $log->setName('Ordu konpentsatuak gehitu');
            $log->setDescription('Fetxa: '.date_format($hour->getDate(), 'Y/m/d').' Orduak: '.$hour->getHours().' Minutuak: '.$hour->getMinutes().' Total: '.$hour->getTotal());
            /** @var User $user */
            $user = $this->getUser();
            $log->setUser($user);

            $em->persist($log);
            $em->persist($calendar);
            $em->persist($hour);
            $em->flush();

            //return $this->redirectToRoute('admin_calendar_edit', array('id' => $calendarid));
            return $this->redirect(
                $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]).'#konpentsatuak'
            );
        }

        return $this->render('hour/new.html.twig', [
            'hour' => $hour,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Displays a form to edit an existing hour entity.
     *
     * @Route("/{id}/edit", name="admin_hour_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Hour    $hour
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Hour $hour)
    {
        $deleteForm = $this->createDeleteForm($hour);
        //$editForm = $this->createForm('AppBundle\Form\HourType', $hour);
        $editForm = $this->createForm(
            HourType::class,
            $hour,
            [
            'action' => $this->generateUrl('admin_hour_edit', ['id' => $hour->getId()]),
            'method' => 'POST',
        ]
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var Calendar $calendar */
            $calendar = $em->getRepository('AppBundle:Calendar')->find($hour->getCalendar()->getId());

            $uow = $em->getUnitOfWork();
            $OriginalEntityData = $uow->getOriginalEntityData($hour);

            $data = $editForm->getData();
            $temp = (float)$OriginalEntityData['total'];

            $calendar->setHoursCompensed((float)$calendar->getHoursCompensed() - $temp + (float)$data->getTotal());

            /** @var Log $log */
            $log = new Log();
            /** @var User $u */
            $u = $this->getUser();
            $log->setUser($u);
            $log->setName('Ordu Konpentsatuak. Zuzenketa.');
            $log->setDescription('Fetxa: '.date_format($hour->getDate(), 'Y/m/d').' Orduak: '.$hour->getHours().' Minutuak: '.$hour->getMinutes().' Total: '.$hour->getTotal());
            $log->setCalendar($calendar);

            $em->persist($log);
            $em->persist($calendar);
            $em->flush();

            //return $this->redirectToRoute('admin_calendar_edit', array('id' => $calendar->getId()));
            return $this->redirect(
                $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]).'#konpentsatuak'
            );
        }

        return $this->render('hour/edit.html.twig', [
            'hour' => $hour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a hour entity.
     *
     * @Route("/{id}", name="admin_hour_delete", methods={"DELETE"})
     * @param Request $request
     * @param Hour    $hour
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Hour $hour): RedirectResponse
    {
        $form = $this->createDeleteForm($hour);
        $form->handleRequest($request);

        /** @var Calendar $calendar */
        $calendar = $hour->getCalendar();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $calendar->setHoursCompensed((float) ($calendar->getHoursCompensed() - (float)$hour->getTotal()));

            /** @var Log $log */
            $log = new Log();
            $log->setCalendar($calendar);
            /** @var User $u */
            $u = $this->getUser();
            $log->setUser($u);
            $log->setName('Ordu konpentsatua ezabatua');
            $log->setDescription('Fetxa: '.date_format($hour->getDate(), 'Y/m/d').' Orduak: '.$hour->getHours().' Minutuak: '.$hour->getMinutes().' Total: '.$hour->getTotal());
            $em->persist($log);

            $em->remove($hour);
            $em->flush();
        }

        return $this->redirect(
            $this->generateUrl('admin_calendar_edit', ['id' => $calendar->getId()]).'#konpentsatuak'
        );
    }

    /**
     * Creates a form to delete a hour entity.
     *
     * @param Hour $hour The hour entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Hour $hour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_hour_delete', ['id' => $hour->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
