<?php

namespace Camaleao\Bimgo\CoreBundle\EventListener;

use Camaleao\Bimgo\CoreBundle\Entity\Produto;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ProdutoListener
{
    /**
     * @param Produto $produto
     * @param LifecycleEventArgs $args
     */
    public function postPersist(Produto $produto, LifecycleEventArgs $args)
    {
        $canonico = \Camaleao\Bimgo\CoreBundle\Service\TextHelper::urlFriendly($produto->getId().'-'.$produto->getNome());
        $produto->setCanonico($canonico);

        $em = $args->getEntityManager();
        $em->flush();
    }

    /**
     * @param Produto $produto
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(Produto $produto, LifecycleEventArgs $args)
    {
        $canonico = \Camaleao\Bimgo\CoreBundle\Service\TextHelper::urlFriendly($produto->getId().'-'.$produto->getNome());
        $produto->setCanonico($canonico);
    }
}