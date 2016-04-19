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
        //$menu->addChild('Papel', array('route' => 'papel_index'));
        //$menu->addChild('Usuário', array('route' => 'usuario_index'));
        //$menu->addChild('Segmento', array('route' => 'segmento_index'));
        $menu->addChild('Segmentos', array('route' => 'segmento_index'));
        $menu->addChild('Empresas', array('route' => 'instituicao_index'));
        $menu->addChild('Promoções', array('route' => 'promocao_index'));
        $menu->addChild('Produtos', array('route' => 'produto_index'));


        return $menu;
    }
}