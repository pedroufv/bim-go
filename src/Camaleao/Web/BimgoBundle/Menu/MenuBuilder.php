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
        if(!empty($options['id']))
            $menu->setChildrenAttribute('id', $options['id']);
        if(!empty($options['class']))
            $menu->setChildrenAttribute('class',  $options['class']);

        $menu->addChild('Home', array('route' => 'default_index'));
        $menu->addChild('Papel', array('route' => 'papel_index'));
        $menu->addChild('Usuário', array('route' => 'usuario_index'));
        $menu->addChild('Empresa', array('route' => 'empresa_index'));

        return $menu;
    }
}