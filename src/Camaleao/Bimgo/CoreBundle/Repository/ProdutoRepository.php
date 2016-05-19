<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProdutoRepository extends EntityRepository
{
    /**
     * Get Estados participantes
     * @return mixed
     */
    public function findByCidade($criteria, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Produto')
            ->createQueryBuilder('produto')
            ->innerJoin('produto.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria['cidade']);

        unset($criteria['cidade']);

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("produto.$key = $value");
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
