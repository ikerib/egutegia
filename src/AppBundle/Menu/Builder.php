<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 3/13/17
 * Time: 8:35 AM
 */

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class Builder
{

    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        $menu->addChild('Home', array(
            'icon' => 'home',
            'route' => 'homepage',
        ));
        $dropdown = $menu->addChild('Subpaginas', array(
            'dropdown' => true,
            'caret' => true,
        ));
        $dropdown->addChild('Subpagina 1', array('route' => 'homepage'));
        $dropdown->addChild('Subpagina 2', array('route' => 'homepage'));
        $dropdown->addChild('Subpagina 3', array('route' => 'homepage'));
        return $menu;
    }
}
