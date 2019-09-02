<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Type;
use AppBundle\Form\TypeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Type controller.
 *
 * @Route("admin/type")
 */
class TypeController extends Controller
{
    /**
     * Lists all type entities.
     *
     * @Route("/", name="admin_type_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $types = $em->getRepository('AppBundle:Type')->findAll();

        $deleteForms = [];
        foreach ($types as $type) {
            $deleteForms[$type->getId()] = $this->createDeleteForm($type)->createView();
        }

        return $this->render('type/index.html.twig', [
            'types' => $types,
            'deleteforms' => $deleteForms,
        ]);
    }

    /**
     * Lists all type entities.
     *
     * @Route("/list/{calendarid}", name="admin_type_list", methods={"GET"})
     *
     * @param mixed $calendarid
     *
     * @return Response
     */
    public function listAction($calendarid): Response
    {
        $em = $this->getDoctrine()->getManager();

        $typesFromCalendarEvents = $em->getRepository('AppBundle:Type')->findAllByOrder($calendarid);
        $typesFromTemplateEvents = $em->getRepository('AppBundle:Type')->findAllTemplateEventsType($calendarid);

        $types = array_merge($typesFromTemplateEvents, $typesFromCalendarEvents);

        return $this->render('type/list.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * Lists all type entities (templates).
     *
     * @Route("/listtemplatetypes/{templateid}", name="admin_type_listtemplates", methods={"GET"})
     *
     * @param mixed $templateid
     *
     * @return Response
     */
    public function listtemplatetypesAction($templateid): Response
    {
        $em = $this->getDoctrine()->getManager();

        $types = $em->getRepository('AppBundle:Type')->findAllTypesOfTemplateEvents($templateid);

        return $this->render('type/list.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * Creates a new type entity.
     *
     * @Route("/new", name="admin_type_new", methods={"GET", "POST"})
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $type = new Type();
        $form = $this->createForm(
            TypeType::class,
            $type,
            [
            'action' => $this->generateUrl('admin_type_new'),
            'method' => 'POST',
        ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();

            return $this->redirectToRoute('admin_type_index');
        }

        return $this->render('type/new.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing type entity.
     *
     * @Route("/{id}/edit", name="admin_type_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Type    $type
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Type $type)
    {
        $deleteForm = $this->createDeleteForm($type);
        $editForm = $this->createForm(
            TypeType::class,
            $type,
            [
            'action' => $this->generateUrl('admin_type_edit', ['id' => $type->getId()]),
            'method' => 'POST',
        ]
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_type_index');
        }

        return $this->render('type/edit.html.twig', [
            'type' => $type,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a type entity.
     *
     * @Route("/{id}", name="admin_type_delete", methods={"DELETE"})
     * @param Request $request
     * @param Type    $type
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Type $type): RedirectResponse
    {
        $form = $this->createDeleteForm($type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($type);
            $em->flush();
        }

        return $this->redirectToRoute('admin_type_index');
    }

    /**
     * Creates a form to delete a type entity.
     *
     * @param Type $type The type entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Type $type)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_type_delete', ['id' => $type->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
