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


        $ldapusers = $ldapService->getAllUsersInfo();

        /****************************************************************************************************************
         ***  OJO ALDATZEN BADA CalendarController newAction ere aldatu *************************************************
         ****************************************************************************************************************/
//        $ldapusers = $ldap->buildLdapQuery()
//            ->select(
//                [
//                    'name',
//                    'guid',
//                    'username',
//                    'emailAddress',
//                    'firstName',
//                    'lastName',
//                    'dn',
//                    'department',
//                    'description',
//                ]
//            )
//            ->fromUsers()->orderBy('username')->getLdapQuery()->getResult();

        $userdata = [];
        foreach ($ldapusers as $user) {

            /** @var $user User */
            $u = [];
            $u['user'] = $user;
            $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear(
                $user['username'],
                date('Y')
            );
            $u['calendar'] = $calendar;

            $egutegiguztiak = $em->getRepository('AppBundle:Calendar')->findAllCalendarsByUsername($user['username']);
            $u[ 'egutegiak' ] = $egutegiguztiak;

            /** @var $usernotes User */
            $usernotes = $em->getRepository('AppBundle:User')->getByUsername($user['username']);

            if ($usernotes) {
                $user->setNotes($usernotes->getNotes());
            }
            $userdata[] = $u;
        }

        $user = new User();
        $frmusernote = $this->createForm(UserNoteType::class, $user);


        return $this->render(
            'default/index.html.twig',
            [
                'userdata' => $userdata,
                'frmusernote' => $frmusernote->createView(),
            ]
        );
    }



}
