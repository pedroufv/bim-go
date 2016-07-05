<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class HistoricoRepository extends EntityRepository
{
    /**
     * obter historicos de um cliente em uma empresa
     * @return mixed
     */
    /*public function findByCidade($criteria, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Instituicao')
            ->createQueryBuilder('instituicao')
            ->leftJoin('instituicao.segmento', 'segmento')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria["cidade"])
            ->groupBy('instituicao.id');

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("instituicao.$key = $value");
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
    }*/
}
