<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PromocaoRepository extends EntityRepository
{
    /**
     * Find Promocao by Cidade
     * @return mixed
     */
    public function findByCidade($criteria, $order = array(), $limit = null, $offset = null)
    {
        $hoje = new \DateTime();

        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Promocao')
            ->createQueryBuilder('promocao')
            ->innerJoin('promocao.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria['cidade'])
            ->andWhere('promocao.publicada = true')
            ->andWhere('promocao.datafim >= '.$hoje->format("Y-m-d"));

        unset($criteria['cidade']);

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("promocao.$key = $value");
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

    /**
     * Find Promocao where publicada is true
     * @return mixed
     */
    public function findByPublicada($criteria, $order, $limit, $offset)
    {
        $criteria['publicada'] = true;
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Promocao')->findBy($criteria, $order, $limit, $offset);

        return $result;
    }
}
