<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Firmadet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\FirmadetType;

/**
 * Firmadet controller.
 *
 * @Route("erantzunak")
 */
class FirmadetController extends Controller
{
    /**
     * Lists all firmadet entities.
     *
     * @Route("/", name="erantzunak_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $firmadets = $em->getRepository('AppBundle:Firmadet')->bilatuDenak();

        return $this->render(
            'firmadet/index.html.twig',
            array(
                'firmadets' => $firmadets,
            )
        );
    }

    /**
     * Creates a new firmadet entity.
     *
     * @Route("/new", name="erantzunak_new", methods={"GET", "POST"})
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $firmadet = new Firmadet();
        $form     = $this->createForm(FirmadetType::class, $firmadet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($firmadet);
            $em->flush();

            return $this->redirectToRoute('erantzunak_show', array('id' => $firmadet->getId()));
        }

        return $this->render(
            'firmadet/new.html.twig',
            array(
                'firmadet' => $firmadet,
                'form'     => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a firmadet entity.
     *
     * @Route("/{id}", name="erantzunak_show", methods={"GET"})
     * @param Firmadet $firmadet
     *
     * @return Response
     */
    public function showAction(Firmadet $firmadet): Response
    {
        $deleteForm = $this->createDeleteForm($firmadet);

        return $this->render(
            'firmadet/show.html.twig',
            array(
                'firmadet'    => $firmadet,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing firmadet entity.
     *
     * @Route("/{id}/edit", name="erantzunak_edit", methods={"GET", "POST"})
     * @param Request  $request
     * @param Firmadet $firmadet
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Firmadet $firmadet)
    {
        $deleteForm = $this->createDeleteForm($firmadet);
        $editForm   = $this->createForm(FirmadetType::class, $firmadet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('erantzunak_edit', array('id' => $firmadet->getId()));
        }

        return $this->render(
            'firmadet/edit.html.twig',
            array(
                'firmadet'    => $firmadet,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a firmadet entity.
     *
     * @Route("/{id}", name="erantzunak_delete", methods={"DELETE"})
     * @param Request  $request
     * @param Firmadet $firmadet
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Firmadet $firmadet): RedirectResponse
    {
        $form = $this->createDeleteForm($firmadet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($firmadet);
            $em->flush();
        }

        return $this->redirectToRoute('erantzunak_index');
    }

    /**
     * Creates a form to delete a firmadet entity.
     *
     * @param Firmadet $firmadet The firmadet entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Firmadet $firmadet)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('erantzunak_delete', array('id' => $firmadet->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
