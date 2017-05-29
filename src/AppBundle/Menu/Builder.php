<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Menu;

use AppBundle\Entity\User;
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
