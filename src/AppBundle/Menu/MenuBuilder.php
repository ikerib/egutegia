<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 14/02/18
 * Time: 12:36
 */

namespace AppBundle\Menu;

use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MenuBuilder
{
    private $factory;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $checker;
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param FactoryInterface              $factory
     *
     * Add any other dependency you need
     * @param AuthorizationCheckerInterface $checker
     * @param EntityManager                 $em
     */
    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $checker, EntityManager $em, TranslatorInterface $translator)
    {
        $this->factory    = $factory;
        $this->checker    = $checker;
        $this->em         = $em;
        $this->translator = $translator;
    }

    public function createMainMenu(array $options): \Knp\Menu\ItemInterface
    {


//            $menu[ 'Taula Laguntzaileak' ]->addChild('Txantiloiak', ['icon' => 'bookmark', 'route' => 'admin_template_index'])->setExtra('translation_domain', 'messages');
//            $menu[ 'Taula Laguntzaileak' ]->addChild('Lizentzia Motak', ['icon' => 'briefcase', 'route' => 'admin_lizentziamota_index'])->setExtra(
//                'translation_domain',
//                'messages'
//            );
//            $menu[ 'Taula Laguntzaileak' ]->addChild('divider', ['divider' => true]);
//            $menu[ 'Taula Laguntzaileak' ]->addChild('Bateraezinak', ['icon' => 'lock', 'route' => 'admin_gutxienekoak_index'])->setExtra('translation_domain', 'messages');
//            $menu[ 'Taula Laguntzaileak' ]->addChild('Sinatzaileak', ['icon' => 'pencil', 'route' => 'admin_sinatzaileak_index'])->setExtra('translation_domain', 'messages');
//            $menu[ 'Taula Laguntzaileak' ]->addChild('divider2', ['divider' => true]);
//            $menu[ 'Taula Laguntzaileak' ]->addChild('Azken konexioak', ['icon' => 'time', 'route' => 'admin_log_index'])->setExtra('translation_domain', 'messages');
//            $menu[ 'Taula Laguntzaileak' ]->addChild('divider3', ['divider' => true]);
//            $menu[ 'Taula Laguntzaileak' ]->addChild('Zerrendak->Konpentsatuak', ['icon' => 'list', 'route' => 'app_zerrenda_konpentsatuak'])->setExtra(
//                'translation_domain',
//                'messages'
//            );
//            $menu[ 'Taula Laguntzaileak' ]->addChild('Zerrendak->Absentismo', ['icon' => 'list', 'route' => 'app_zerrenda_absentismo'])->setExtra('translation_domain', 'messages');
//            $menu[ 'Taula Laguntzaileak' ]->addChild('divider4', ['divider' => true]);
//            $menu[ 'Taula Laguntzaileak' ]->addChild('Jakinarazpen guztiak', ['icon' => 'notify', 'route' => 'notification_list'])->setExtra('translation_domain', 'messages');
//
//            $eskaerak = $this->em->getRepository('AppBundle:Eskaera')->findBideratugabeak();
//
//            if (\count($eskaerak) > 0) {
//                $menu->addChild(
//                    'Eskaerak',
//                    array(
//                        'route'           => 'admin_eskaera_list',
//                        'routeParameters' => array('q' => 'no-way', 'history' => '0'),
//                        'icon'            => 'inbox',
//                        'label'           => $this->translator->trans('main_menu.eskaerak')." <span class='badge badge-error'>".\count($eskaerak)."</span>",
//                        'extras'          => array('safe_label' => true),
//                    )
//                );
//            } else {
//                $menu->addChild('Eskaerak', ['icon' => 'inbox', 'route' => 'admin_eskaera_list'])
//                     ->setLinkAttribute('class', 'childClass')->setExtra('translation_domain', 'messages');
//            }
//        }


//        return $menu;
    }
}
