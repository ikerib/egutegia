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
        $ldap = $this->get('ldap_tools.ldap_manager');

        $users = $ldap->buildLdapQuery()->fromUsers()->orderBy('username')->getLdapQuery()->getResult();

        $users->count();

        return $this->render('default/index.html.twig', array('users'=>$users));
    }
}
