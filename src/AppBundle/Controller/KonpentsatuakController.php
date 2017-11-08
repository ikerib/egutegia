<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Konpentsatuak;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Konpentsatuak controller.
 *
 * @Route("konpentsatuak")
 */
class KonpentsatuakController extends Controller
{
    /**
     * Lists all konpentsatuak entities.
     *
     * @Route("/", name="konpentsatuak_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $konpentsatuaks = $em->getRepository('AppBundle:Konpentsatuak')->findAll();

        return $this->render('konpentsatuak/index.html.twig', array(
            'konpentsatuaks' => $konpentsatuaks,
        ));
    }

    /**
     * Creates a new konpentsatuak entity.
     *
     * @Route("/new", name="konpentsatuak_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();

        /** @var Calendar $calendar */
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear(
            $user->getUsername(),
            date('Y')
        );

        $calendar = $calendar[ 0 ];

        $konpentsatuak = new Konpentsatuak();
        $form = $this->createForm('AppBundle\Form\KonpentsatuakType', $konpentsatuak);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($konpentsatuak);
            $em->flush();

            return $this->redirectToRoute('konpentsatuak_show', array('id' => $konpentsatuak->getId()));
        }

        return $this->render('konpentsatuak/new.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
            'calendar'=> $calendar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a konpentsatuak entity.
     *
     * @Route("/{id}", name="konpentsatuak_show")
     * @Method("GET")
     */
    public function showAction(Konpentsatuak $konpentsatuak)
    {
        $deleteForm = $this->createDeleteForm($konpentsatuak);

        return $this->render('konpentsatuak/show.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing konpentsatuak entity.
     *
     * @Route("/{id}/edit", name="konpentsatuak_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Konpentsatuak $konpentsatuak)
    {
        $deleteForm = $this->createDeleteForm($konpentsatuak);
        $editForm = $this->createForm('AppBundle\Form\KonpentsatuakType', $konpentsatuak);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('konpentsatuak_edit', array('id' => $konpentsatuak->getId()));
        }

        return $this->render('konpentsatuak/edit.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a konpentsatuak entity.
     *
     * @Route("/{id}", name="konpentsatuak_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Konpentsatuak $konpentsatuak)
    {
        $form = $this->createDeleteForm($konpentsatuak);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($konpentsatuak);
            $em->flush();
        }

        return $this->redirectToRoute('konpentsatuak_index');
    }

    /**
     * Creates a form to delete a konpentsatuak entity.
     *
     * @param Konpentsatuak $konpentsatuak The konpentsatuak entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Konpentsatuak $konpentsatuak)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('konpentsatuak_delete', array('id' => $konpentsatuak->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
