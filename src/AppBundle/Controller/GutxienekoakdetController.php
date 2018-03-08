<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gutxienekoakdet;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Gutxienekoakdet controller.
 *
 * @Route("admin/gutxienekoakdet")
 */
class GutxienekoakdetController extends Controller
{
    /**
     * Lists all gutxienekoakdet entities.
     *
     * @Route("/", name="admin_gutxienekoakdet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gutxienekoakdets = $em->getRepository('AppBundle:Gutxienekoakdet')->findAll();

        return $this->render('gutxienekoakdet/index.html.twig', array(
            'gutxienekoakdets' => $gutxienekoakdets,
        ));
    }

    /**
     * Creates a new gutxienekoakdet entity.
     *
     * @Route("/new/{gutxiid}", name="admin_gutxienekoakdet_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param         $gutxiid
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws EntityNotFoundException
     */
    public function newAction(Request $request, $gutxiid)
    {
        $em = $this->getDoctrine()->getManager();
        $gutxi = $em->getRepository( 'AppBundle:Gutxienekoak' )->find( $gutxiid );
        if (!$gutxi) {
            throw New EntityNotFoundException('Ez da gutxieneko zerrenda aurkitu.');
        }

        $gutxienekoakdet = new Gutxienekoakdet();
        $gutxienekoakdet->setGutxienekoak( $gutxi );
        $form = $this->createForm('AppBundle\Form\GutxienekoakdetType', $gutxienekoakdet, [
            'action' => $this->generateUrl('admin_gutxienekoakdet_new', array('gutxiid'=>$gutxiid)),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gutxienekoakdet);
            $em->flush();

            //return $this->redirectToRoute('admin_gutxienekoakdet_show', array('id' => $gutxienekoakdet->getId()));
            return $this->redirectToRoute('admin_gutxienekoak_show', array('id' => $gutxi->getId()));
        }

        return $this->render('gutxienekoakdet/new.html.twig', array(
            'gutxienekoakdet' => $gutxienekoakdet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gutxienekoakdet entity.
     *
     * @Route("/{id}", name="admin_gutxienekoakdet_show")
     * @Method("GET")
     * @param Gutxienekoakdet $gutxienekoakdet
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Gutxienekoakdet $gutxienekoakdet)
    {
        $deleteForm = $this->createDeleteForm($gutxienekoakdet);

        return $this->render('gutxienekoakdet/show.html.twig', array(
            'gutxienekoakdet' => $gutxienekoakdet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gutxienekoakdet entity.
     *
     * @Route("/{id}/edit", name="admin_gutxienekoakdet_edit")
     * @Method({"GET", "POST"})
     * @param Request         $request
     * @param Gutxienekoakdet $gutxienekoakdet
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Gutxienekoakdet $gutxienekoakdet)
    {
        $deleteForm = $this->createDeleteForm($gutxienekoakdet);
        $editForm = $this->createForm('AppBundle\Form\GutxienekoakdetType', $gutxienekoakdet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gutxienekoakdet_edit', array('id' => $gutxienekoakdet->getId()));
        }

        return $this->render('gutxienekoakdet/edit.html.twig', array(
            'gutxienekoakdet' => $gutxienekoakdet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gutxienekoakdet entity.
     *
     * @Route("/{id}", name="admin_gutxienekoakdet_delete")
     * @Method("DELETE")
     * @param Request         $request
     * @param Gutxienekoakdet $gutxienekoakdet
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Gutxienekoakdet $gutxienekoakdet)
    {
        $form = $this->createDeleteForm($gutxienekoakdet);
        $form->handleRequest($request);

        $miid = $gutxienekoakdet->getGutxienekoak()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gutxienekoakdet);
            $em->flush();
        }

        return $this->redirectToRoute('admin_gutxienekoak_show', array('id'=>$miid));
    }

    /**
     * Creates a form to delete a gutxienekoakdet entity.
     *
     * @param Gutxienekoakdet $gutxienekoakdet The gutxienekoakdet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gutxienekoakdet $gutxienekoakdet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_gutxienekoakdet_delete', array('id' => $gutxienekoakdet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
