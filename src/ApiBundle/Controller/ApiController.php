<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\TemplateEvent;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ApiController extends FOSRestController {

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
     * @param $templateid
     * @return array|View
     * @Annotations\View()
     * @Get("/templateevents/{templateid}")
     */
    public function getTemplateEventsAction($templateid)
    {
        $em = $this->getDoctrine()->getManager();

        $tevents = $em->getRepository('AppBundle:TemplateEvent')->getTemplateEvents($templateid);

        if ($tevents === null)
        {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $tevents;
    }

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
        $em = $this->getDoctrine()->getManager();
        $jsonData = json_decode($request->getContent(), true);

        // bilatu egutegia
        $template = $em->getRepository('AppBundle:Template')->find($jsonData['templateid']);

        /** @var TemplateEvent $templateevent */
        $templateevent = new TemplateEvent();
        $templateevent->setTemplate($template);
        $templateevent->setName($jsonData['name']);
        $tempini = new \DateTime($jsonData['startDate']);
        $templateevent->setStartDate($tempini);
        $tempfin = new \DateTime($jsonData['endDate']);
        $templateevent->setEndDate($tempfin);

        $em->persist($templateevent);
        $em->flush();

        $view = View::create();
        $view->setData($templateevent);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        return $view;

    }// "post_templateevents"            [POST] /templateevents


}