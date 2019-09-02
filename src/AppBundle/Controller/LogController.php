<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Log;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Log controller.
 *
 * @Route("admin/log")
 */
class LogController extends Controller
{
    /**
     * Lists all log entities.
     *
     * @Route("/", name="admin_log_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $logs = $em->getRepository('AppBundle:Log')->findLoginlogs();

        return $this->render('log/index.html.twig', array(
            'logs' => $logs,
        ));
    }
}
