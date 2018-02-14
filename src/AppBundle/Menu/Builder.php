<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Menu;

use AppBundle\Entity\User;
use AppBundle\Service\NotificationService;
use AppBundle\Service\Sinatzeke;
use AppBundle\Service\SinatzekeService;
use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    public function mainMenu( FactoryInterface $factory, array $options )
    {
        $menu = $factory->createItem( 'root', [ 'navbar' => true ] );

        $menu->addChild( ' Hasiera', [ 'icon' => 'home', 'route' => 'dashboard' ] );
        $menu->addChild( 'Taula Laguntzaileak', [ 'icon' => 'th-list' ] );
        $menu[ 'Taula Laguntzaileak' ]->addChild( 'Motak', [ 'icon' => 'tag', 'route' => 'admin_type_index' ] );
        $menu[ 'Taula Laguntzaileak' ]->addChild( ' Txantiloia', [ 'icon' => 'bookmark', 'route' => 'admin_template_index' ] );
        $menu[ 'Taula Laguntzaileak' ]->addChild( 'divider', [ 'divider' => true ] );

        $checker = $this->container->get( 'security.authorization_checker' );
        if ( ( $checker->isGranted( 'ROLE_USER' ) && ( $checker->isGranted( 'ROLE_BIDERATZAILEA' ) ) ) || ( $checker->isGranted( 'ROLE_SUPER_ADMIN' ) ) ) {
            $menu[ 'Taula Laguntzaileak' ]->addChild( ' Bateraezinak', [ 'icon' => 'lock', 'route' => 'admin_gutxienekoak_index' ] );
            $menu[ 'Taula Laguntzaileak' ]->addChild( ' Sinatzaileak', [ 'icon' => 'pencil', 'route' => 'admin_sinatzaileak_index' ] );
            /** @var EntityManager $em */
            $em = $this->container->get( 'doctrine.orm.entity_manager' );
            $eskaerak = $em->getRepository( 'AppBundle:Eskaera' )->findBideratugabeak();

            if ( count( $eskaerak ) > 0 ) {
                //$menu->addChild(' ADI!!! Eskaerak', ['icon' => 'inbox', 'route' => 'admin_eskaera_list']);
                $menu->addChild(
                    'Eskaerak',
                    array(
                        'route'           => 'admin_eskaera_list',
                        'routeParameters' => array( 'q' => 'all' ),
                        'icon'            => 'inbox',
                        'label'           => "Eskaera <span class='badge badge-error'>" . count( $eskaerak ) . "</span>",
                        'extras'          => array( 'safe_label' => true ),
                    )
                );
            } else {
                $menu->addChild( ' Eskaerak', [ 'icon' => 'inbox', 'route' => 'admin_eskaera_list' ] )
                     ->setLinkAttribute( 'class', 'childClass' );
            }
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'divider2', [ 'divider' => true ] );
            $menu[ 'Taula Laguntzaileak' ]->addChild( ' Azken konexioak', [ 'icon' => 'time', 'route' => 'admin_log_index' ] );
        }


        return $menu;
    }

    public
    function userMenu( FactoryInterface $factory, array $options )
    {
        /*
        * Sinatze ditu eskaerak??
        */
        /** @var NotificationService $zerbitzua */
        $zerbitzua = $this->container->get( 'app.sinatzeke' );
        $notifications = $zerbitzua->GetNotifications();

        $checker = $this->container->get( 'security.authorization_checker' );
        /** @var $user User */
        $user = $this->container->get( 'security.token_storage' )->getToken()->getUser();


        $menu = $factory->createItem( 'root', [ 'navbar' => true, 'icon' => 'user' ] );

        if ( $checker->isGranted( 'ROLE_USER' ) ) {
            if ( count( $notifications ) == 0 ) {
                $menu->addChild(
                    'User',
                    array(
                        'label'    => $user->getDisplayname(),
                        'dropdown' => true,
                        'icon'     => 'user',
                    )
                );
            } else {
                $menu->addChild(
                    'User',
                    array(
                        'label'    => $user->getDisplayname() . " <span class='badge badge-error'>" . count(
                                $notifications
                            ) . "</span>",
                        'dropdown' => true,
                        'icon'     => 'user',
                        'extras'   => array( 'safe_label' => true ),
                    )
                );
            }

            $menu[ 'User' ]->addChild(
                ' Egutegia',
                array(
                    'route' => 'user_homepage',
                    'icon'  => 'calendar',
                )
            );

            $menu[ 'User' ]->addChild(
                ' Fitxategiak',
                array(
                    'route' => 'user_documents',
                    'icon'  => 'folder-open',
                )
            );

            $menu[ 'User' ]->addChild(
                ' Eskaerak',
                array(
                    'route' => 'eskaera_index',
                    'icon'  => 'send',
                )
            );
            $menu[ 'User' ]->addChild( 'divider', [ 'divider' => true ] );

            if ( ( !$checker->isGranted( 'ROLE_BIDERATZAILEA' ) ) && ( ( $checker->isGranted( 'ROLE_ADMIN' ) ) ) ) {
                $menu[ 'User' ]->addChild(
                    ' Jakinarazpenak',
                    array(
                        'label'  => " Jakinarazpenak <span class='badge badge-error'>" . count( $notifications ) . "</span>",
                        'route'  => 'notification_index',
                        'icon'   => 'bullhorn',
                        'extras' => array( 'safe_label' => true ),
                    )
                );
                $menu[ 'User' ]->addChild( 'divider2', [ 'divider' => true ] );
            }


            $menu[ 'User' ]->addChild(
                ' Irten',
                array(
                    'route' => 'fos_user_security_logout',
                    'icon'  => 'log-out',
                )
            );

        } else {
            $menu->addChild( 'login', [ 'route' => 'fos_user_security_login' ] );
        }


        return $menu;
    }

    public
    function subMenuLeft( FactoryInterface $factory, array $options )
    {
        $request = $this->container->get( 'request_stack' )->getCurrentRequest();
        $routeName = $request->get( '_route' );

        $menu = $factory->createItem(
            'root',
            [
                'navbar' => true,
            ]
        );
        $menu->setChildrenAttribute( 'class', 'navbar navbar-default navbar-lower affix-top' );

        if ( strpos( $routeName, 'egutegia' ) !== false ) {
            $menu->addChild( 'Egutegiak', [ 'uri' => 'javascript:void(0);' ] );
        } else {
            $menu->addChild( 'Txantiloiak', [ 'uri' => 'javascript:void(0);' ] );
        }

        return $menu;
    }

    public
    function subMenuRight( FactoryInterface $factory, array $options )
    {
        $request = $this->container->get( 'request_stack' )->getCurrentRequest();
        $routeName = $request->get( '_route' );
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
        $menu->setChildrenAttribute( 'class', 'navbar navbar-default navbar-lower affix-top' );

        if ( !in_array( $routeName, $noToolBarRouteNames, true ) ) {
            $menu->addChild(
                'Egutegia Ezabatu',
                [
                    'attributes' => [
                        'id'    => 'btnEzabatu',
                        'class' => 'btn btn-danger navbar-btn',
                    ],
                ]
            );
            $menu->addChild(
                'Egutegia Grabatu',
                [
                    'attributes' => [
                        'id'    => 'btnGrabatu',
                        'class' => 'btn btn-primary navbar-btn',
                    ],
                ]
            );
        }

        return $menu;
    }
}
