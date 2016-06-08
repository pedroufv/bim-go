<?php

namespace Camaleao\Bimgo\CoreBundle\Menu;

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

        $menu->addChild('Início', array('route' => 'inicial_index'));
        $menu->addChild('Segmentos', array('route' => 'site_segmento_index'));
        $menu->addChild('Empresas', array('route' => 'site_instituicao_index'));
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

        $menu->addChild('Início', array('route' => 'inicial_index'));
        //$menu->addChild('Segmentos', array('route' => 'segmento_index'));
        $menu->addChild('Empresas', array('route' => 'site_instituicao_index'));
        $menu->addChild('Promoções', array('route' => 'site_promocao_index'));
        $menu->addChild('Produtos', array('route' => 'site_produto_index'));


        return $menu;
    }
}