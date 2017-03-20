<?php

namespace ApiBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Event;
use AppBundle\Entity\Template;
use AppBundle\Entity\TemplateEvent;
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
     * Get template Events
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Get template events",
     *   statusCodes = {
     *     200 = "OK"
     *   }
     * )
     *
     * @return array|View
     *
     * @Annotations\View()
     */
    public function getTemplateEventsAction($templateid)
    {
        $em         = $this->getDoctrine()->getManager();
        $events = $em->getRepository('AppBundle:Event')->findAll();

        $view = View::create();
        $view->setData($events);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }// "get_templateevents"            [GET] /templateevents

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
    public function postTemplateEventsAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $jsonData = json_decode($request->getContent(), true)[0];

        // bilatu egutegia
        $template = $em->getRepository('AppBundle:Template')->find($jsonData[ 'templateid' ]);

        $templateevent = new TemplateEvent();
        $templateevent->setTemplate($template);
        $templateevent->setName($jsonData[ 'name' ]);


        $em->persist($templateevent);
        $em->flush();

        $view = View::create();
        $view->setData($templateevent);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }// "post_templateevents"            [POST] /templateevents



}