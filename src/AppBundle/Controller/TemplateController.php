<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Template controller.
 *
 * @Route("admin/template")
 */
class TemplateController extends Controller
{
    /**
     * Lists all template entities.
     *
     * @Route("/", name="admin_template_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $templates = $em->getRepository('AppBundle:Template')->findAll();

        return $this->render('template/index.html.twig', array(
            'templates' => $templates,
        ));
    }

    /**
     * Creates a new template entity.
     *
     * @Route("/new", name="admin_template_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $template = new Template();
        $form = $this->createForm('AppBundle\Form\TemplateType', $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($template);
            $em->flush();

            return $this->redirectToRoute('admin_template_edit', array('id' => $template->getId()));
        }

        return $this->render('template/new.html.twig', array(
            'template' => $template,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a template entity.
     *
     * @Route("/{id}", name="admin_template_show")
     * @Method("GET")
     */
    public function showAction(Template $template)
    {
        $deleteForm = $this->createDeleteForm($template);

        return $this->render('template/show.html.twig', array(
            'template' => $template,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing template entity.
     *
     * @Route("/{id}/edit", name="admin_template_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Template $template)
    {
        $deleteForm = $this->createDeleteForm($template);
        $editForm = $this->createForm('AppBundle\Form\TemplateType', $template);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_template_edit', array('id' => $template->getId()));
        }

        return $this->render('template/edit.html.twig', array(
            'template' => $template,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a template entity.
     *
     * @Route("/{id}", name="admin_template_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Template $template)
    {
        $form = $this->createDeleteForm($template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($template);
            $em->flush();
        }

        return $this->redirectToRoute('admin_template_index');
    }

    /**
     * Creates a form to delete a template entity.
     *
     * @param Template $template The template entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Template $template)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_template_delete', array('id' => $template->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
