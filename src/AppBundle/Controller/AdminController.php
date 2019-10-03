<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserNoteType;
use AppBundle\Service\LdapService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/dashboard", name="dashboard")
     *
     * @param LdapService $ldapService
     *
     * @return Response
     *
     * @internal param Request $request
     */
    public function dashboardAction(LdapService $ldapService): Response
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();


        /****************************************************************************************************************
         ***  TODO:  OJO ALDATZEN BADA CalendarController newAction ere aldatu *************************************************
         ****************************************************************************************************************/

        $users = $em->getRepository('AppBundle:User')->findAllUsersAndCalendars();

        $user = new User();
        $frmusernote = $this->createForm(UserNoteType::class, $user);

        return $this->render(
            'default/index.html.twig',
            [
                'users' => $users,
                'frmusernote' => $frmusernote->createView(),
            ]
        );
    }

    /**
     * @Route("/sync", name="sync")
     * @param LdapService $ldapService
     *
     * @return RedirectResponseAlias
     */
    public function sincronizeUserEntityWithLdapData(LdapService $ldapService): RedirectResponseAlias
    {
        $ldapService->sincronizeUserEntityWithLdapData();

        return $this->redirectToRoute('dashboard');

    }

}
