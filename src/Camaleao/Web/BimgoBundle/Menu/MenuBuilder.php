<?php

namespace Camaleao\Web\BimgoBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('id', 'nav-mobile');
        $menu->setChildrenAttribute('class', 'right hide-on-med-and-dow');

        $menu->addChild('Home', array('route' => 'default_index'));
        $menu->addChild('Estado', array('route' => 'estado_index'));

        return $menu;
    }

    public function navMobileMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('id', 'mobile-demo');
        $menu->setChildrenAttribute('class', 'side-nav');

        $menu->addChild('Home', array('route' => 'default_index'));
        $menu->addChild('Estado', array('route' => 'estado_index'));

        return $menu;
    }
}