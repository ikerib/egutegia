<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Notification controller.
 *
 * @Route("notification")
 */
class NotificationController extends Controller
{

    /**
     * Lists all notification entities.
     *
     * @Route("/", name="notification_index", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        /**
         * Parametroak baditu hauek izan daitezke:
         * -1 Irakurri gabe
         * 0 Guztiak
         * 1 Irakurritakoak
         */
        $em   = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $q = $request->query->get('q');

        if ($q === null) {
            $q = null;
        }

        $notifications = $em->getRepository('AppBundle:Notification')->getCurrentUserNotifications($user->getId(), $q);

        return $this->render(
            'notification/index.html.twig',
            array(
                'notifications' => $notifications,
                'user'          => $user,
            )
        );
    }

    /**
     * Lists all notification entities for everyone. Only ROLE_SUPER_ADMIN
     *
     * @Route("/sinatzen", name="notification_sinatzen", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function sinatzenAction(Request $request): Response
    {


        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $q = $request->query->get('q');

        if ($q === null) {
            $q = null;
        }

        $notifications = $em->getRepository('AppBundle:Notification')->getCurrentUserNotifications($user->getId(), $q);


        return $this->render(
            'notification/sinatzen.html.twig',
            array(
                'notifications' => $notifications
            )
        );
    }


    /**
     * Lists all notification entities for everyone. Only ROLE_SUPER_ADMIN
     *
     * @Route("/list", name="notification_list", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        /**
         * Parametroak baditu hauek izan daitezke:
         * -1 Irakurri gabe
         * 0 Guztiak
         * 1 Irakurritakoak
         */
        $em = $this->getDoctrine()->getManager();

        $q = $request->query->get('q');

        if ($q === null) {
            $q = null;
        }

        $notifications = $em->getRepository('AppBundle:Notification')->getAllUserNotifications($q);

        $deleteForms = [];
        foreach ($notifications as $notify) {
            /** @var Notification $notify */
            $deleteForms[ $notify->getId() ] = $this->createDeleteForm($notify)->createView();
        }

        return $this->render(
            'notification/list.html.twig',
            array(
                'notifications' => $notifications,
                'deleteforms'   => $deleteForms,
            )
        );
    }


    /**
     * Finds and displays a notification entity.
     *
     * @Route("/{id}", name="notification_show", methods={"GET"})
     * @param Notification $notification
     *
     * @return Response
     */
    public function showAction(Notification $notification): Response
    {

        return $this->render(
            'notification/show.html.twig',
            array(
                'notification' => $notification,
            )
        );
    }

    /**
     * Deletes a type entity.
     *
     * @Route("/{id}", name="notification_delete", methods={"DELETE"})
     * @param Request      $request
     * @param Notification $notify
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Notification $notify): RedirectResponse
    {
        $form = $this->createDeleteForm($notify);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notify);
            $em->flush();
        }

        return $this->redirectToRoute('notification_list');
    }

    /**
     * Creates a form to delete a type entity.
     *
     * @param Notification $notify The type entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Notification $notify)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('notification_delete', ['id' => $notify->getId()]))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
