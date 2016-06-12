<?php

namespace Camaleao\Bimgo\MemberBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function siteMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        if(!empty($options['id']))
            $menu->setChildrenAttribute('id', $options['id']);
        if(!empty($options['class']))
            $menu->setChildrenAttribute('class',  $options['class']);

        $menu->addChild('Início', array('route' => 'site_inicial_index'));
        $menu->addChild('Segmentos', array('route' => 'site_segmento_index'));
        $menu->addChild('Instituições', array('route' => 'site_instituicao_index'));
        $menu->addChild('Promoções', array('route' => 'site_promocao_index'));
        $menu->addChild('Produtos', array('route' => 'site_produto_index'));

        return $menu;
    }

    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        if(!empty($options['id']))
            $menu->setChildrenAttribute('id', $options['id']);
        if(!empty($options['class']))
            $menu->setChildrenAttribute('class',  $options['class']);

        //$menu->addChild('Início', array('route' => 'admin_inicial_index'));
        $menu->addChild('Segmentos', array('route' => 'admin_segmento_index'));
        $menu->addChild('Instituições', array('route' => 'admin_instituicao_index'));
        $menu->addChild('Promoções', array('route' => 'admin_promocao_index'));
        $menu->addChild('Produtos', array('route' => 'admin_produto_index'));

        return $menu;
    }
}