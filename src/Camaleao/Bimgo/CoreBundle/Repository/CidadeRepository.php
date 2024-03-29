<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CidadeRepository extends EntityRepository
{
    /**
     * Get Estados participantes
     * @return mixed
     */
    public function findByEstadosParticipantes()
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Cidade')
            ->createQueryBuilder('cidade')
            ->select('estado.id, estado.nome, estado.uf')
            ->innerJoin('cidade.estado', 'estado')
            ->where("cidade.participante = true")
            ->groupBy('estado.id')
            ->getQuery()
            ->getResult();

        return $result;
    }
}
