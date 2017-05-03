<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Form\UserNoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ldap = $this->get('ldap_tools.ldap_manager');
        /* OJO ALDATZEN BADA CalendarController newAction ere aldatu */
        $ldapusers = $ldap->buildLdapQuery()
            ->select(['name', 'guid', 'username', 'emailAddress', 'firstName', 'lastName', 'dn', 'department', 'description'])
            ->fromUsers()->orderBy('username')->getLdapQuery()->getResult();


        $userdata=[];
        foreach ($ldapusers as $user) {
            $u = [];
            $u["user"] = $user;
            $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear(
                $user->getUsername(),
                Date('Y')
            );
            $u[ "calendar" ] = $calendar;

            $usernotes = $em->getRepository( 'AppBundle:User' )->getByUsername( $user->getUsername() );

            if ($usernotes) {
                $user->setNotes( $usernotes->getNotes() );
            }


            array_push($userdata, $u);
        }

        $user = new User();
        $frmusernote = $this->createForm( UserNoteType::class, $user );

        return $this->render(
            'default/index.html.twig',
            array(
                'userdata'=>$userdata,
                'frmusernote' => $frmusernote->createView()
            )
        );
    }
}
