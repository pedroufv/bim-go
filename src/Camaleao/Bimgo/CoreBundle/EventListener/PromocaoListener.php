<?php

namespace Camaleao\Bimgo\CoreBundle\EventListener;

use Camaleao\Bimgo\CoreBundle\Entity\Promocao;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PromocaoListener
{
    /**
     * @param Promocao $promocao
     * @param LifecycleEventArgs $args
     */
    public function postPersist(Promocao $promocao, LifecycleEventArgs $args)
    {
        $canonico = \Camaleao\Bimgo\CoreBundle\Service\TextHelper::urlFriendly($promocao->getId().'-'.$promocao->getNome());
        $promocao->setCanonico($canonico);

        $em = $args->getEntityManager();
        $em->flush();
    }

    /**
     * @param Promocao $promocao
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(Promocao $promocao, LifecycleEventArgs $args)
    {
        $canonico = \Camaleao\Bimgo\CoreBundle\Service\TextHelper::urlFriendly($promocao->getId().'-'.$promocao->getNome());
        $promocao->setCanonico($canonico);
    }
}