<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;

/**
 * User controller.
 *
 * @Route("admin/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="admin_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();


        return $this->render('user/index.html.twig', array(
            'users'         => $users,
        ));
    }

    /**
     * @Route("/alta/{id}", name="admin_user_alta")
     * @Method("GET")
     */
    public function altaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository('AppBundle:User')->find($id);
        $user->setAktibo(1);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * @Route("/baja/{id}", name="admin_user_baja")
     * @Method("GET")
     */
    public function bajaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository('AppBundle:User')->find($id);
        $user->setAktibo(0);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin_user_index');
    }

}
