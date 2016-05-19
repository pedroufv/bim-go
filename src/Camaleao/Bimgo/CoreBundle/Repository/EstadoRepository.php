<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EstadoRepository extends EntityRepository
{
    /**
     * Get Estados participantes
     * @return mixed
     */
    public function findByCidadeParticipante($criteria, $order, $limit, $offset)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Cidade')
            ->createQueryBuilder('cidade')
            ->select('estado.id, estado.nome, estado.uf')
            ->innerJoin('cidade.estado', 'estado');

        if(isset($criteria['participante'])) {
            $result->where("cidade.participante = ".$criteria['participante']);
            unset($criteria['participante']);
        }

        $result->groupBy('estado.id');

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("estado.$key = $value");
            }
        }

        if(count($order) > 0) {
            foreach($order as $key => $value){
                $result->addOrderBy($key, $value);
            }
        }

        if($offset)
            $result->setFirstResult($offset);

        if($limit)
            $result->setMaxResults($limit);

        return $result->getQuery()->getResult();
    }
}
