<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction ()
    {
        $user = $this->getUser();

        return $this->render(
            'default/homepage.html.twig',
            array(
                'user' => $user,
            )
        );
    }

    /**
     * @Route("/user", name="user_homepage")
     */
    public function userhomepageAction ()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $user User */
        $user     = $this->getUser();
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear($user->getUsername(), Date('Y'));

        if (( ! $calendar ) || ( count($calendar) > 1 )) {
            throw new EntityNotFoundException('Ez da egutegirik topatu edo egutegi bat baino gehiago ditu');
        }


        return $this->render(
            'default/user_homepage.html.twig',
            array(
                'user'     => $user,
                'calendar' => $calendar[0],
            )
        );
    }

}
