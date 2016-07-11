<?php

namespace Camaleao\Bimgo\CoreBundle\EventListener;

use Camaleao\Bimgo\CoreBundle\Entity\Instituicao;
use Doctrine\ORM\Event\LifecycleEventArgs;

class InstituicaoListener
{
    /**
     * @param Instituicao $instituicao
     * @param LifecycleEventArgs $args
     */
    public function postPersist(Instituicao $instituicao, LifecycleEventArgs $args)
    {
        $canonico = \Camaleao\Bimgo\CoreBundle\Service\TextHelper::urlFriendly($instituicao->getId().'-'.$instituicao->getNomefantasia());
        $instituicao->setCanonico($canonico);

        $em = $args->getEntityManager();
        $em->flush();
    }

    /**
     * @param Instituicao $instituicao
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(Instituicao $instituicao, LifecycleEventArgs $args)
    {
        $canonico = \Camaleao\Bimgo\CoreBundle\Service\TextHelper::urlFriendly($instituicao->getId().'-'.$instituicao->getNomefantasia());
        $instituicao->setCanonico($canonico);
    }
}