<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 3/13/17
 * Time: 8:35 AM
 */

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;


class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $em = $this->container->get('doctrine')->getManager();
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        $menu->addChild('Hasiera', array(
            'icon'  => 'home',
            'route' => 'dashboard',
        ));

        $dropdown = $menu->addChild('Txantiloiak', array(
            'dropdown' => true,
            'caret'    => true,
        ));
        $dropdown->addChild('Zerrenda', array('route' => 'admin_template_index'));
        $dropdown->addChild('Berria', array('route' => 'admin_template_new'));

        $menu->addChild('Motak', array(
            'dropdown' => true,
            'caret'    => true,
        ));
        $menu['Motak']->addChild('Zerrenda', array('route' => 'admin_type_index'));
        $menu['Motak']->addChild('Berria', array('route' => 'admin_type_new'));




        $menu->addChild('User', array('label' => 'Kaixo user'))
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-user');
        $menu['User']->addChild('Edit profile', array('route' => 'homepage'))
            ->setAttribute('icon', 'fa fa-edit');


        $sc = $this->container->get('security.context');

        if($sc->getToken())
        {
            $menu->addChild('Members', array('uri' => '#'))
                ->setAttribute('dropdown', true);

            if($sc->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            {
                $menu['Members']->addChild('My profile', array('route' => 'fos_user_profile_show'));

                if($sc->isGranted('ROLE_ADMIN'))
                {
                    $menu['Members']->addChild('Dashboard', array('route' => 'sonata_admin_dashboard'))
                        ->setAttribute('divider_append', true);
                }

                $menu['Members']->addChild('Logout', array('route' => 'fos_user_security_logout'));
            }
            else
            {
                $menu['Members']->addChild('Login', array('route' => 'fos_user_security_login'));
                $menu['Members']->addChild('Registration', array('route' => 'fos_user_registration_register'));
            }
        }

        return $menu;
    }

    public function subMenuLeft(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));
        $menu->setChildrenAttribute('class', 'navbar navbar-default navbar-lower affix-top');
        $menu->addChild('Txantiloiak', array('uri' => 'javascript:void(0);'));
        
        return $menu;
    }

    public function subMenuRight(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));
        $menu->setChildrenAttribute('class', 'navbar navbar-default navbar-lower affix-top');
        $menu->addChild('Grabatu', array(
            'attributes' => array(
                'id' => 'btnGrabatu',
                'class' => 'btn btn-primary navbar-btn'
            )
        ));


        return $menu;
    }
}
