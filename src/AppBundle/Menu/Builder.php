<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Menu;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', ['navbar' => true]);

        $menu->addChild(' Hasiera', ['icon' => 'home', 'route' => 'dashboard']);
        $menu->addChild(' Txantiloia', ['icon' => 'bookmark', 'route' => 'admin_template_index']);
        $menu->addChild(' Mota', ['icon' => 'tag', 'route' => 'admin_type_index']);
        $menu->addChild(' Bateraezinak', ['icon' => 'lock', 'route' => 'admin_gutxienekoak_index']);
        $menu->addChild(' Sinatzaileak', ['icon' => 'pencil', 'route' => 'admin_sinatzaileak_index']);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');
        $eskaerak = $em->getRepository( 'AppBundle:Eskaera' )->findBideratugabeak();

        if (count($eskaerak) > 0) {
            //$menu->addChild(' ADI!!! Eskaerak', ['icon' => 'inbox', 'route' => 'admin_eskaera_list']);
            $menu->addChild(
                'Eskaerak',
                array(
                    'route'      => 'admin_eskaera_list',
                    'icon' => 'inbox',
                    'label' => "Eskaera <span class='badge badge-error'>".count($eskaerak) . "</span>",
                    'extras' => array('safe_label' => true),
                )
            );
        } else {
            $menu->addChild(' Eskaerak', ['icon' => 'inbox', 'route' => 'admin_eskaera_list'])
                ->setLinkAttribute('class', 'childClass');

        }



        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $checker = $this->container->get('security.authorization_checker');
        /** @var $user User */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $menu = $factory->createItem('root', ['navbar' => true, 'icon' => 'glyphicon glyphicon-user']);

        if ($checker->isGranted('ROLE_USER') || ($checker->isGranted('ROLE_ADMIN'))) {
            $menu->addChild('User', ['label' => $user->getDisplayname()])
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'glyphicon glyphicon-user');
            $menu['User']->addChild('Egutegia', ['route' => 'user_homepage'])
                    ->setAttribute('icon', 'fa fa-edit');

            $menu['User']->addChild('Fitxategiak', ['route' => 'user_documents'])
                ->setAttribute('icon', 'fa fa-edit');

            $menu['User']->addChild('Eskaerak', ['route' => 'eskaera_index'])
                ->setAttribute('icon', 'fa fa-telegram');

            $menu['User']->addChild('Irten', ['route' => 'fos_user_security_logout']);
        } else {
            $menu->addChild('login', ['route' => 'fos_user_security_login']);
        }

        return $menu;
    }

    public function subMenuLeft(FactoryInterface $factory, array $options)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $routeName = $request->get('_route');

        $menu = $factory->createItem(
            'root',
            [
                'navbar' => true,
            ]
        );
        $menu->setChildrenAttribute('class', 'navbar navbar-default navbar-lower affix-top');

        if (strpos($routeName, 'egutegia') !== false) {
            $menu->addChild('Egutegiak', ['uri' => 'javascript:void(0);']);
        } else {
            $menu->addChild('Txantiloiak', ['uri' => 'javascript:void(0);']);
        }

        return $menu;
    }

    public function subMenuRight(FactoryInterface $factory, array $options)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $routeName = $request->get('_route');
        $noToolBarRouteNames = [
            'dashboard',
            'admin_template_index',
        ];

        $menu = $factory->createItem(
            'root',
            [
                'navbar' => true,
            ]
        );
        $menu->setChildrenAttribute('class', 'navbar navbar-default navbar-lower affix-top');

        if (!in_array($routeName, $noToolBarRouteNames, true)) {
            $menu->addChild(
                'Egutegia Ezabatu',
                [
                    'attributes' => [
                        'id' => 'btnEzabatu',
                        'class' => 'btn btn-danger navbar-btn',
                    ],
                ]
            );
            $menu->addChild(
                'Egutegia Grabatu',
                [
                    'attributes' => [
                        'id' => 'btnGrabatu',
                        'class' => 'btn btn-primary navbar-btn',
                    ],
                ]
            );
        }

        return $menu;
    }
}
