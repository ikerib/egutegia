<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sinatzaileakdet;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sinatzaileakdet controller.
 *
 * @Route("admin/sinatzaileakdet")
 */
class SinatzaileakdetController extends Controller
{
    /**
     * Lists all sinatzaileakdet entities.
     *
     * @Route("/", name="admin_sinatzaileakdet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sinatzaileakdets = $em->getRepository('AppBundle:Sinatzaileakdet')->findAll();

        return $this->render('sinatzaileakdet/index.html.twig', array(
            'sinatzaileakdets' => $sinatzaileakdets,
        ));
    }

    /**
     * Creates a new sinatzaileakdet entity.
     *
     * @Route("/new/{sinatzaileid}", name="admin_sinatzaileakdet_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param         $sinatzaileid
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws EntityNotFoundException
     */
    public function newAction(Request $request, $sinatzaileid)
    {
        $em = $this->getDoctrine()->getManager();
        $sina = $em->getRepository( 'AppBundle:Sinatzaileak' )->find( $sinatzaileid );
        if (!$sina) {
            throw New EntityNotFoundException( 'Ez da sinatzaile zerrenda topatu' );
        }
        $sinatzaileakdet = new Sinatzaileakdet();
        $sinatzaileakdet->setSinatzaileak( $sina );
        $form = $this->createForm('AppBundle\Form\SinatzaileakdetType', $sinatzaileakdet, [
            'action' => $this->generateUrl('admin_sinatzaileakdet_new', array('sinatzaileid'=>$sina->getId())),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sinatzaileakdet);
            $em->flush();

            //return $this->redirectToRoute('admin_sinatzaileakdet_show', array('id' => $sinatzaileakdet->getId()));
            return $this->redirectToRoute('admin_sinatzaileak_show', array('id' => $sina->getId()));
        }

        return $this->render('sinatzaileakdet/new.html.twig', array(
            'sinatzaileakdet' => $sinatzaileakdet,
            'form' => $form->createView(),
        ));

    }

    /**
     * Finds and displays a sinatzaileakdet entity.
     *
     * @Route("/{id}", name="admin_sinatzaileakdet_show")
     * @Method("GET")
     * @param Sinatzaileakdet $sinatzaileakdet
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Sinatzaileakdet $sinatzaileakdet)
    {
        $deleteForm = $this->createDeleteForm($sinatzaileakdet);

        return $this->render('sinatzaileakdet/show.html.twig', array(
            'sinatzaileakdet' => $sinatzaileakdet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sinatzaileakdet entity.
     *
     * @Route("/{id}/edit", name="admin_sinatzaileakdet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sinatzaileakdet $sinatzaileakdet)
    {
        $deleteForm = $this->createDeleteForm($sinatzaileakdet);
        $editForm = $this->createForm('AppBundle\Form\SinatzaileakdetType', $sinatzaileakdet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_sinatzaileakdet_edit', array('id' => $sinatzaileakdet->getId()));
        }

        return $this->render('sinatzaileakdet/edit.html.twig', array(
            'sinatzaileakdet' => $sinatzaileakdet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sinatzaileakdet entity.
     *
     * @Route("/{id}", name="admin_sinatzaileakdet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sinatzaileakdet $sinatzaileakdet)
    {
        $form = $this->createDeleteForm($sinatzaileakdet);
        $form->handleRequest($request);

        $miid = $sinatzaileakdet->getSinatzaileak()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sinatzaileakdet);
            $em->flush();
        }

        //return $this->redirectToRoute('admin_sinatzaileakdet_index');
        return $this->redirectToRoute('admin_sinatzaileak_show', array('id'=>$miid));
    }

    /**
     * Creates a form to delete a sinatzaileakdet entity.
     *
     * @param Sinatzaileakdet $sinatzaileakdet The sinatzaileakdet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sinatzaileakdet $sinatzaileakdet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_sinatzaileakdet_delete', array('id' => $sinatzaileakdet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
