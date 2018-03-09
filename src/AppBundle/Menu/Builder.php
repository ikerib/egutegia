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
        $checker = $this->container->get( 'security.authorization_checker' );

        $menu = $factory->createItem( 'root', [ 'navbar' => true ] );


        if ( $checker->isGranted( 'ROLE_BIDERATZAILEA' ) || ( $checker->isGranted( 'ROLE_SUPER_ADMIN' ) ) ) {

            $menu->addChild( 'Hasiera', [ 'icon' => 'home', 'route' => 'dashboard' ] )->setExtra('translation_domain','messages');
            $menu->addChild( 'Taula Laguntzaileak', [ 'icon' => 'th-list' ] )->setExtra('translation_domain','messages');
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'Motak', [ 'icon' => 'tag', 'route' => 'admin_type_index' ] )->setExtra('translation_domain','messages');
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'Txantiloiak', [ 'icon' => 'bookmark', 'route' => 'admin_template_index' ] )->setExtra('translation_domain','messages');
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'divider', [ 'divider' => true ] );
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'Bateraezinak', [ 'icon' => 'lock', 'route' => 'admin_gutxienekoak_index' ] )->setExtra('translation_domain','messages');
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'Sinatzaileak', [ 'icon' => 'pencil', 'route' => 'admin_sinatzaileak_index' ] )->setExtra('translation_domain','messages');
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'divider2', [ 'divider' => true ] );
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'Azken konexioak', [ 'icon' => 'time', 'route' => 'admin_log_index' ] )->setExtra('translation_domain','messages');
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'divider3', [ 'divider' => true ] );
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'Zerrendak', [ 'icon' => 'list', 'route' => 'zerrenda_konpentsatuak' ] )->setExtra('translation_domain','messages');
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'divider4', [ 'divider' => true ] );
            $menu[ 'Taula Laguntzaileak' ]->addChild( 'Jakinarazpen guztiak', [ 'icon' => 'notify', 'route' => 'notification_list' ] )->setExtra('translation_domain','messages');
        }


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
                    'label'           => $this->container->get("translator")->trans("Eskaerak") . " <span class='badge badge-error'>" . count( $eskaerak ) . "</span>",
                    'extras'          => array( 'safe_label' => true ),
                )
            );
        } else {
            $menu->addChild( 'Eskaerak', [ 'icon' => 'inbox', 'route' => 'admin_eskaera_list' ] )
                 ->setLinkAttribute( 'class', 'childClass' )->setExtra('translation_domain','messages');
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
                $menu->addChild('User', array( 'label' => $user->getDisplayname(), 'dropdown' => true, 'icon' => 'user'));
            } else {
                $menu->addChild('User', array(
                    'label'    => $user->getDisplayname() . " <span class='badge badge-error'>" . count($notifications) . "</span>",
                    'dropdown' => true,
                    'icon'     => 'user',
                    'extras'   => array( 'safe_label' => true ),
                    )
                );
            }

            $menu[ 'User' ]->addChild('Egutegia', array(
                    'route' => 'user_homepage',
                    'icon'  => 'calendar',
                )
            )->setExtra('translation_domain','messages');

            $menu[ 'User' ]->addChild('Fitxategiak', array(
                    'route' => 'user_documents',
                    'icon'  => 'folder-open',
                )
            )->setExtra('translation_domain','messages');

            $menu[ 'User' ]->addChild('Eskaerak', array(
                    'route' => 'eskaera_index',
                    'icon'  => 'send',
                )
            )->setExtra('translation_domain','messages');

            $menu[ 'User' ]->addChild( 'divider', [ 'divider' => true ] );

            if ( ( !$checker->isGranted( 'ROLE_BIDERATZAILEA' ) ) && ( ( $checker->isGranted( 'ROLE_ADMIN' ) ) ) ) {
                $menu[ 'User' ]->addChild(
                    'Jakinarazpenak',
                    array(
                        'label'  => $this->container->get("translator")->trans("Jakinarazpenak") . " <span class='badge badge-error'>" . count( $notifications ) . "</span>",
                        'route'  => 'notification_index',
                        'icon'   => 'bullhorn',
                        'extras' => array( 'safe_label' => true ),
                    )
                )->setExtra('translation_domain','messages');
                $menu[ 'User' ]->addChild( 'divider2', [ 'divider' => true ] );
            }


            $menu[ 'User' ]->addChild('Irten', array(
                    'route' => 'fos_user_security_logout',
                    'icon'  => 'log-out',
                )
            )->setExtra('translation_domain','messages');

        } else {
            $menu->addChild( 'login', [ 'route' => 'fos_user_security_login' ] );
        }


        return $menu;
    }
}
