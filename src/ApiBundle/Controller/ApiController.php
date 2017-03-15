<?php

namespace ApiBundle\Controller;

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
        $events = $em->getRepository('AppBundle:Calendar')->findAll();

        $view = View::create();
        $view->setData($events);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }// "get_events"            [GET] /events



}