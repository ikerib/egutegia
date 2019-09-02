<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gutxienekoak;
use AppBundle\Entity\Gutxienekoakdet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\GutxienekoakType;

/**
 * Gutxienekoak controller.
 *
 * @Route("admin/gutxienekoak")
 */
class GutxienekoakController extends Controller
{
    /**
     * Lists all gutxienekoak entities.
     *
     * @Route("/", name="admin_gutxienekoak_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $gutxienekoaks = $em->getRepository('AppBundle:Gutxienekoak')->findAll();

        $deleteForms = [];
        foreach ($gutxienekoaks as $e) {
            /** @var Gutxienekoak $e */
            $deleteForms[ $e->getId() ] = $this->createDeleteForm($e)->createView();
        }

        return $this->render('gutxienekoak/index.html.twig', array(
            'gutxienekoaks' => $gutxienekoaks,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new gutxienekoak entity.
     *
     * @Route("/new", name="admin_gutxienekoak_new", methods={"GET", "POST"})

     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $gutxienekoak = new Gutxienekoak();
        $form = $this->createForm(
            GutxienekoakType::class,
            $gutxienekoak,
            [
            'action' => $this->generateUrl('admin_gutxienekoak_new'),
            'method' => 'POST',
        ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gutxienekoak);
            $em->flush();

            return $this->redirectToRoute('admin_gutxienekoak_show', array('id' => $gutxienekoak->getId()));
        }

        return $this->render('gutxienekoak/new.html.twig', array(
            'gutxienekoak' => $gutxienekoak,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gutxienekoak entity.
     *
     * @Route("/{id}", name="admin_gutxienekoak_show", methods={"GET"})
     * @param Gutxienekoak $gutxienekoak
     *
     * @return Response
     */
    public function showAction(Gutxienekoak $gutxienekoak): Response
    {
        $deleteForm = $this->createDeleteForm($gutxienekoak);

        $deleteForms = [];
        /** @var Gutxienekoakdet $gd */
        $gd = $gutxienekoak->getGutxienekoakdet();
        foreach ($gd as $g) {
            /** @var Gutxienekoakdet $g */
            $deleteForms[$g->getId()] = $this->createDeleteFormGutxienekoakDet($g)->createView();
        }
        return $this->render('gutxienekoak/show.html.twig', array(
            'gutxienekoak' => $gutxienekoak,
            'delete_form' => $deleteForm->createView(),
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Displays a form to edit an existing gutxienekoak entity.
     *
     * @Route("/{id}/edit", name="admin_gutxienekoak_edit", methods={"GET", "POST"})
     * @param Request      $request
     * @param Gutxienekoak $gutxienekoak
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Gutxienekoak $gutxienekoak)
    {
        $deleteForm = $this->createDeleteForm($gutxienekoak);
        $editForm = $this->createForm(GutxienekoakType::class, $gutxienekoak);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            //return $this->redirectToRoute('admin_gutxienekoak_edit', array('id' => $gutxienekoak->getId()));
            return $this->redirectToRoute('admin_gutxienekoak_index');
        }

        return $this->render('gutxienekoak/edit.html.twig', array(
            'gutxienekoak' => $gutxienekoak,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gutxienekoak entity.
     *
     * @Route("/{id}", name="admin_gutxienekoak_delete", methods={"DELETE"})
     * @param Request      $request
     * @param Gutxienekoak $gutxienekoak
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Gutxienekoak $gutxienekoak)
    {
        $form = $this->createDeleteForm($gutxienekoak);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gutxienekoak);
            $em->flush();
        }

        return $this->redirectToRoute('admin_gutxienekoak_index');
    }

    /**
     * Creates a form to delete a gutxienekoak entity.
     *
     * @param Gutxienekoak $gutxienekoak The gutxienekoak entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Gutxienekoak $gutxienekoak)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_gutxienekoak_delete', array('id' => $gutxienekoak->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a gutxienekoak entity.
     *
     * @param Gutxienekoakdet $gd
     *
     * @return Form|FormInterface
     * @internal param Gutxienekoak $gutxienekoak The gutxienekoak entity
     *
     */
    private function createDeleteFormGutxienekoakDet(Gutxienekoakdet $gd)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_gutxienekoakdet_delete', array('id' => $gd->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
