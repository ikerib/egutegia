<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ldap = $this->get('ldap_tools.ldap_manager');
        $ldapusers = $ldap->buildLdapQuery()->fromUsers()->orderBy('username')->getLdapQuery()->getResult();

        $userdata=[];
        foreach ($ldapusers as $user) {
            $u = [];
            $u["user"] = $user;
            $calendar = $em->getRepository('AppBundle:Calendar')->findByUsername($user->getUsername());
            $u[ "calendar" ] = $calendar;
            array_push($userdata, $u);
        }


        return $this->render('default/index.html.twig', array('userdata'=>$userdata));
    }
}
