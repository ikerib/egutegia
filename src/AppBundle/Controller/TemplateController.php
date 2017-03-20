<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Template;
use AppBundle\Form\TemplateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Template controller.
 *
 * @Route("admin/template")
 */
class TemplateController extends Controller {

    /**
     * Lists all template entities.
     *
     * @Route("/", name="admin_template_index")
     * @Method("GET")
     */
    public function indexAction ()
    {
        $em = $this->getDoctrine()->getManager();

        $templates = $em->getRepository('AppBundle:Template')->findAll();

        $deleteForms = array();
        foreach ($templates as $template) {
            $deleteForms[ $template->getId() ] = $this->createDeleteForm($template)->createView();
        }

        return $this->render(
            'template/index.html.twig',
            array(
                'templates'   => $templates,
                'deleteforms' => $deleteForms,
            )
        );
    }

    /**
     * Creates a new template entity.
     *
     * @Route("/new", name="admin_template_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction (Request $request)
    {
        $template = new Template();
        $form     = $this->createForm(
            TemplateType::class,
            $template,
            array(
                'action' => $this->generateUrl('admin_template_new'),
                'method' => 'POST',
            )
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($template);
            $em->flush();

            return $this->redirectToRoute('admin_template_edit', array( 'id' => $template->getId() ));
        }

        return $this->render(
            'template/new.html.twig',
            array(
                'template' => $template,
                'form'     => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a template entity.
     *
     * @Route("/{id}", name="admin_template_show")
     * @Method("GET")
     * @param Template $template
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction (Template $template)
    {
        $deleteForm = $this->createDeleteForm($template);

        return $this->render(
            'template/show.html.twig',
            array(
                'template'    => $template,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing template entity.
     *
     * @Route("/{id}/edit", name="admin_template_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Template $template
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction (Request $request, Template $template)
    {
        $deleteForm = $this->createDeleteForm($template);
        $editForm   = $this->createForm('AppBundle\Form\TemplateType', $template);
        $editForm->handleRequest($request);

        $em    = $this->getDoctrine()->getManager();
        $types = $em->getRepository('AppBundle:Type')->findAll();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_template_edit', array( 'id' => $template->getId() ));
        }

        return $this->render(
            'template/edit.html.twig',
            array(
                'template'    => $template,
                'types'       => $types,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a template entity.
     *
     * @Route("/{id}", name="admin_template_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Template $template
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction (Request $request, Template $template)
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
    private function createDeleteForm (Template $template)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_template_delete', array( 'id' => $template->getId() )))
            ->setMethod('DELETE')
            ->getForm();
    }
}
