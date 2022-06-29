<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Kuadrantea;
use AppBundle\Entity\User;
use AppBundle\Form\UserNoteType;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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
     * @return Response
     *
     * @internal param Request $request
     */
    public function dashboardAction(): Response
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $ldap = $this->get('ldap_tools.ldap_manager');

        /****************************************************************************************************************
         ***  OJO ALDATZEN BADA CalendarController newAction ere aldatu *************************************************
         ****************************************************************************************************************/
        $ldapusers = $ldap->buildLdapQuery()
            ->select(
                [
                    'name',
                    'guid',
                    'username',
                    'emailAddress',
                    'firstName',
                    'lastName',
                    'dn',
                    'department',
                    'description',
                ]
            )
            ->fromUsers()->orderBy('username')->getLdapQuery()->getResult();

        $userdata = [];
        foreach ($ldapusers as $user) {
            /** @var $user User */
            $u = [];
            $u['user'] = $user;
            $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear(
                $user->getUsername(),
                date('Y')
            );
            $u['calendar'] = $calendar;

            $egutegiguztiak = $em->getRepository('AppBundle:Calendar')->findAllCalendarsByUsername($user->getUsername());
            $u[ 'egutegiak' ] = $egutegiguztiak;

            /** @var $usernotes User */
            $usernotes = $em->getRepository('AppBundle:User')->getByUsername($user->getUsername());

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

    /**
     * @Route("/kuadrantea", name="admin_kuadrantea")
     *
     * @return Response
     *
     * @internal param Request $request
     **/
    public function kuadranteaAction(Request $request): ?Response
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $sailak = $em->getRepository('AppBundle:User')->getSailak();

        $saila = $request->query->get('saila');
        if (($saila) && !($saila==="-1") ){
            $results = $em->getRepository('AppBundle:Kuadrantea')->findallSaila($saila);
        } else {
            $results = $em->getRepository('AppBundle:Kuadrantea')->findall();
        }

        $year = date('Y');
        // urteko lehen astea bada, aurreko urtea aukeratu
        $date_now = new DateTime();
//        $date2    = new DateTime("06/01/".$year);
        $date2    = new DateTime($year.'-01-06');

        if ($date_now <= $date2) {
            --$year;
        }
        return $this->render('default/kuadrantea.html.twig', [
            'results' => $results,
            'year' => $year,
            'sailak' => $sailak
        ]);
    }

    /**
     * @Route("/urteko-balantzea", name="admin_urteko_balantzea")
     *
     * @return Response
     *
     * @internal param Request $request
     **/
    public function urtekoBalantzeaAction(Request $request): ?Response
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $year = $request->get('year') ?: null;

        $results = [];
        if ($year !== null) {
            $results = $em->getRepository('AppBundle:Calendar')->findByYear($year);
        }

        //dump($results[0]);

        return $this->render('default/urteko_balantzea.html.twig', [
            'results' => $results,
            'year' => $year
        ]);
    }


    /**
     * @Route ("/print/{id}", name="print_calendar")
     */
    public function printCalendarAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $calendar = $em->getRepository('AppBundle:Calendar')->find($id);

        return $this->render('default/calendar_print.html.twig', [
            'calendar' => $calendar
        ]);
    }
}
