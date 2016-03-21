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
        $menu->setChildrenAttribute('id', $options['id']);
        $menu->setChildrenAttribute('class',  $options['class']);

        $menu->addChild('Home', array('route' => 'default_index'));
        $menu->addChild('Cliente', array('route' => 'cliente_index'));
        $menu->addChild('Empresa', array('route' => 'empresa_index'));
        $menu->addChild('Funcionário', array('route' => 'funcionario_index'));
        $menu->addChild('Grupo Empresas', array('route' => 'grupoempresas_index'));
        $menu->addChild('Pagamento', array('route' => 'pagamento_index'));
        $menu->addChild('Produto', array('route' => 'produto_index'));
        $menu->addChild('Promoção', array('route' => 'promocao_index'));

        return $menu;
    }
}