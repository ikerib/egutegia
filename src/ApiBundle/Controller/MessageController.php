<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Form\MessageType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageController extends AbstractFOSRestController
{
    public function getMessagesAction(): \FOS\RestBundle\View\View
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->findAll();

        $ctx = new Context();
        $ctx->addGroup('main');
        return View::create($messages, Response::HTTP_OK)->setContext($ctx);
    }

    public function getMessageAction($id): \FOS\RestBundle\View\View
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('AppBundle:Message')->find($id);

        $ctx = new Context();
        $ctx->addGroup('main');
        return View::create($message, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Post(options={"expose": true})
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \FOS\RestBundle\View\View
     */
    public function postMessagesAction(Request $request): \FOS\RestBundle\View\View
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $ctx = new Context();
            $ctx->addGroup('main');
            return View::create($message, Response::HTTP_OK)->setContext($ctx);
        }
        return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);

    }


    public function deleteMessagesAction($id): View
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Message $message */
        $msg = $em->getRepository('AppBundle:Message')->find($id);
        $em->remove($msg);
        $em->flush();

        return View::create(null, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/messages/new/nouser", name="messages_new", options={"expose": true})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMessagesNewAction(): Response
    {
        $msg = new Message();
        $form   = $this->createForm(MessageType::class, $msg);

        return $this->render('message/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Rest\Get(options={"expose": true})
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMessagesNewUserAction($id): \Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var \AppBundle\Entity\User $user */
        $user = $em->getRepository('AppBundle:User')->find($id);
        if (!$user) {
            throw  new NotFoundHttpException('User not found.');
        }
        $msg = new Message();
        $msg->setUser($user);
        $form   = $this->createForm(MessageType::class, $msg);

        return $this->render('message/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
