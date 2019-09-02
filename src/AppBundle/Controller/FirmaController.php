<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Firma;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\FirmaType;

/**
 * Firma controller.
 *
 * @Route("admin/firm")
 */
class FirmaController extends Controller
{
    /**
     * Lists all firma entities.
     *
     * @Route("/", name="admin_firma_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $firmas = $em->getRepository('AppBundle:Firma')->findAll();

        return $this->render('firma/index.html.twig', array(
            'firmas' => $firmas,
        ));
    }

    /**
     * Creates a new firma entity.
     *
     * @Route("/new", name="admina_firm_new", methods={"GET", "POST"})
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $firma = new Firma();
        $form = $this->createForm(FirmaType::class, $firma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($firma);
            $em->flush();

            return $this->redirectToRoute('admin_firma_show', array('id' => $firma->getId()));
        }

        return $this->render('firma/new.html.twig', array(
            'firma' => $firma,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a firma entity.
     *
     * @Route("/{id}", name="admin_firma_show", methods={"GET"})
     * @param Firma $firma
     *
     * @return Response
     */
    public function showAction(Firma $firma): Response
    {
        $deleteForm = $this->createDeleteForm($firma);

        return $this->render('firma/show.html.twig', array(
            'firma' => $firma,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing firma entity.
     *
     * @Route("/{id}/edit", name="admin_firma_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Firma   $firma
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Firma $firma)
    {
        $deleteForm = $this->createDeleteForm($firma);
        $editForm = $this->createForm(FirmaType::class, $firma);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_firma_edit', array('id' => $firma->getId()));
        }

        return $this->render('firma/edit.html.twig', array(
            'firma' => $firma,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a firma entity.
     *
     * @Route("/{id}", name="admin_firma_delete", methods={"DELETE"})
     * @param Request $request
     * @param Firma   $firma
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Firma $firma): RedirectResponse
    {
        $form = $this->createDeleteForm($firma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($firma);
            $em->flush();
        }

        return $this->redirectToRoute('admin_firma_index');
    }

    /**
     * Creates a form to delete a firma entity.
     *
     * @param Firma $firma The firma entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Firma $firma)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_firma_delete', array('id' => $firma->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
