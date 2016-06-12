<?php

namespace Camaleao\Bimgo\AdminBundle\Menu;

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

        $menu->addChild('Segmentos', array('route' => 'admin_segmento_index'));
        $menu->addChild('Instituições', array('route' => 'admin_instituicao_index'));
        $menu->addChild('Promoções', array('route' => 'admin_promocao_index'));
        $menu->addChild('Produtos', array('route' => 'admin_produto_index'));

        return $menu;
    }
}