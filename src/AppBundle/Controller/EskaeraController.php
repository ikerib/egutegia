<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Eskaera;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Eskaera controller.
 *
 * @Route("eskaera")
 */
class EskaeraController extends Controller
{
    /**
     * Lists all eskaera entities.
     *
     * @Route("/", name="eskaera_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        /** @var User $user */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $eskaeras = $em->getRepository('AppBundle:Eskaera')->findAllByUser($user->getId());

        return $this->render('eskaera/index.html.twig', array(
            'eskaeras' => $eskaeras,
        ));
    }

    /**
     * Creates a new eskaera entity.
     *
     * @Route("/new", name="eskaera_new")
     * @Method({"GET", "POST"})
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

        $eskaera = new Eskaera();
        $eskaera->setUser( $user );
        $eskaera->setName( $user->getDisplayname() );
        $eskaera->setCalendar( $calendar );
        $form = $this->createForm('AppBundle\Form\EskaeraType', $eskaera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eskaera);
            $em->flush();

            return $this->redirectToRoute('eskaera_show', array('id' => $eskaera->getId()));

        }

        return $this->render('eskaera/new.html.twig', array(
            'eskaera' => $eskaera,
            'calendar'=> $calendar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a eskaera entity.
     *
     * @Route("/{id}", name="eskaera_show")
     * @Method("GET")
     */
    public function showAction(Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $deleteForm = $this->createDeleteForm($eskaera);

        return $this->render('eskaera/show.html.twig', array(
            'eskaera' => $eskaera,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and prints a eskaera entity.
     *
     * @Route("/print/{id}", name="eskaera_print")
     * @Method("GET")
     * @param Eskaera $eskaera
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printAction(Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        return $this->render('eskaera/print.html.twig', array(
            'eskaera' => $eskaera
        ));
    }

    /**
     * Displays a form to edit an existing eskaera entity.
     *
     * @Route("/{id}/edit", name="eskaera_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $deleteForm = $this->createDeleteForm($eskaera);
        $editForm = $this->createForm('AppBundle\Form\EskaeraType', $eskaera);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eskaera_edit', array('id' => $eskaera->getId()));
        }

        return $this->render('eskaera/edit.html.twig', array(
            'eskaera' => $eskaera,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a eskaera entity.
     *
     * @Route("/{id}", name="eskaera_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $form = $this->createDeleteForm($eskaera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eskaera);
            $em->flush();
        }

        return $this->redirectToRoute('eskaera_index');
    }

    /**
     * Creates a form to delete a eskaera entity.
     *
     * @param Eskaera $eskaera The eskaera entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Eskaera $eskaera)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eskaera_delete', array('id' => $eskaera->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}