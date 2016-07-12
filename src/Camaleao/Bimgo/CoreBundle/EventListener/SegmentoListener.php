<?php

namespace Camaleao\Bimgo\CoreBundle\EventListener;

use Camaleao\Bimgo\CoreBundle\Entity\Segmento;
use Doctrine\ORM\Event\LifecycleEventArgs;

class SegmentoListener
{
    /**
     * @param Segmento $segmento
     * @param LifecycleEventArgs $args
     */
    public function postPersist(Segmento $segmento, LifecycleEventArgs $args)
    {
        $canonico = \Camaleao\Bimgo\CoreBundle\Service\TextHelper::urlFriendly($segmento->getId().'-'.$segmento->getNome());
        $segmento->setCanonico($canonico);

        $em = $args->getEntityManager();
        $em->flush();
    }

    /**
     * @param Segmento $segmento
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(Segmento $segmento, LifecycleEventArgs $args)
    {
        $canonico = \Camaleao\Bimgo\CoreBundle\Service\TextHelper::urlFriendly($segmento->getId().'-'.$segmento->getNome());
        $segmento->setCanonico($canonico);
    }
}