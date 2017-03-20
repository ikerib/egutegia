<?php

namespace ApiBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Event;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends FOSRestController
{

    /**
     * Egutegia eskuratu.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Egutegia eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     * @return array|View
     *
     * @Annotations\View()
     */
    public function getEventsAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $events = $em->getRepository('AppBundle:Event')->findAll();

        $view = View::create();
        $view->setData($events);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }// "get_events"            [GET] /events

    /**
     * Save events.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Save a event",
     *   statusCodes = {
     *     200 = "OK response"
     *   }
     * )
     *
     * @var Request $request
     * @Annotations\View()
     * @param Request $request
     * @return static
     */
    public function postEventsAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $jsonData = json_decode($request->getContent(), true)[0];

        // bilatu egutegia
        $calendar = $em->getRepository('AppBundle:Calendar')->find($jsonData[ 'templateid' ]);
        // bilatu mota
        $type = $em->getRepository('AppBundle:Type')->find($jsonData[ 'type' ]);

        $event = new Event();
        $event->setCalendar($calendar);
        $event->setName($jsonData[ 'name' ]);
        $event->setType($type);
        $em->persist($event);
        $em->flush();

        $view = View::create();
        $view->setData($event);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }// "post_events"            [POST] /events



}