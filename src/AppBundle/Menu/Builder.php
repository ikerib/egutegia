<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 3/13/17
 * Time: 8:35 AM
 */

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class Builder {

    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        $menu->addChild('Hasiera', array(
            'icon'  => 'home',
            'route' => 'homepage',
        ));

        $dropdown = $menu->addChild('Txantiloiak', array(
            'dropdown' => true,
            'caret'    => true,
        ));
        $dropdown->addChild('Zerrenda', array('route' => 'admin_template_index'));
        $dropdown->addChild('Berria', array('route' => 'admin_template_new'));


        $menu->addChild('User', array('label' => 'Kaixo user'))
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-user');
        $menu['User']->addChild('Edit profile', array('route' => 'homepage'))
            ->setAttribute('icon', 'fa fa-edit');

        return $menu;
    }

    public function subMenuLeft(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));
        $menu->setChildrenAttribute('class', 'navbar navbar-default navbar-lower affix-top');

        $menu->addChild('Txantiloiak', array('uri' => 'javascript:void(0);'));


        $menu->addChild('Gorde', array('uri' => 'javascript:void(0);'));
        $menu['Gorde']->setAttribute('id', 'btnGorde');
        $menu['Gorde']->setAttribute('class', 'pull-right');



        return $menu;
    }

    //TODO: ESKUINEKO MENUA => GORDE EZEZTATU


    public function subMenuRight(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
    //
    //    $menu->setAttribute('class', 'navbar-right');
    //    //$menu->setAttributes(array(
    //    //    'class' => 'navbar-right'));
    //    //$menu->setChildrenAttribute('class', 'navbar-right');
    //
    //    $menu->addChild('eskuin');
    //    $menu['eskuin']->setLabelAttribute('class', 'no-link-span');
    //
    //
        return $menu;
    }
}
