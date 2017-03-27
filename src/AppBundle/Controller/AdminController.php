<?php

namespace AppBundle\Controller;

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
        $ldapusers = $ldap->buildLdapQuery()->fromUsers()->orderBy('username')->getLdapQuery()->getResult();

        $userdata=[];
        foreach ($ldapusers as $user) {
            $u = [];
            $u["user"] = $user;
            $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear(
                $user->getUsername(),
                Date('Y')
            );
            $u[ "calendar" ] = $calendar;
            array_push($userdata, $u);
        }


        return $this->render('default/index.html.twig', array('userdata'=>$userdata));
    }
}
