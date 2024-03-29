<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PontuacaoRepository extends EntityRepository
{
    /**
     * obter pontuacoes de um cliente em uma empresa por cidade
     * @return mixed
     */
    public function findByCidade($criteria, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Pontuacao')
            ->createQueryBuilder('pontuacao')
            ->innerJoin('pontuacao.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->where("endereco.cidade = ".$criteria['cidade']);

        unset($criteria['cidade']);

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("pontuacao.$key = $value");
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
