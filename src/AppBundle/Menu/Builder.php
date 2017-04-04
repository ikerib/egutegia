<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 3/13/17
 * Time: 8:35 AM
 */

namespace AppBundle\Menu;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface {

    use ContainerAwareTrait;


    public function mainMenu (FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root',array('navbar' => true,));

        $menu->addChild('Hasiera',array('icon'  => 'home','route' => 'dashboard',));

        $dropdown = $menu->addChild('Txantiloiak',array('dropdown' => true,'caret'    => true,));
        $dropdown->addChild('Zerrenda', array( 'route' => 'admin_template_index' ));


        $menu->addChild(
            'Motak',
            array(
                'dropdown' => true,
                'caret'    => true,
            )
        );
        $menu[ 'Motak' ]->addChild('Zerrenda', array( 'route' => 'admin_type_index' ));

        return $menu;
    }

    public function userMenu (FactoryInterface $factory, array $options) {

        $checker = $this->container->get('security.authorization_checker');
        /** @var $user User */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $menu = $factory->createItem('root',array('navbar' => true,'icon'=>'glyphicon glyphicon-user'));

        if ($checker->isGranted('ROLE_USER') || ($checker->isGranted('ROLE_ADMIN'))) {
            $menu->addChild('User', array( 'label' =>  $user->getDisplayname() ))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'glyphicon glyphicon-user');

            if ($checker->isGranted('ROLE_ADMIN')) {
                $menu[ 'User' ]->addChild('Egutegia', array( 'route' => 'dashboard' ))
                    ->setAttribute('icon', 'fa fa-edit');
            } else {
                $menu[ 'User' ]->addChild('Egutegia', array( 'route' => 'user_homepage' ))
                    ->setAttribute('icon', 'fa fa-edit');
            }

            $menu['User']->addChild('Irten', array('route' => 'fos_user_security_logout'));
        } else {
            $menu->addChild('login', array('route' => 'fos_user_security_login'));
        }

        return $menu;

    }

    public function subMenuLeft (FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem(
            'root',
            array(
                'navbar' => true,
            )
        );
        $menu->setChildrenAttribute('class', 'navbar navbar-default navbar-lower affix-top');
        $menu->addChild('Txantiloiak', array( 'uri' => 'javascript:void(0);' ));

        return $menu;
    }

    public function subMenuRight (FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem(
            'root',
            array(
                'navbar' => true,
            )
        );
        $menu->setChildrenAttribute('class', 'navbar navbar-default navbar-lower affix-top');
        $menu->addChild(
            'Egutegia Ezabatu',
            array(
                'attributes' => array(
                    'id'    => 'btnEzabatu',
                    'class' => 'btn btn-danger navbar-btn',
                ),
            )
        );
        $menu->addChild(
            'Egutegia Grabatu',
            array(
                'attributes' => array(
                    'id'    => 'btnGrabatu',
                    'class' => 'btn btn-primary navbar-btn',
                ),
            )
        );


        return $menu;
    }
}
