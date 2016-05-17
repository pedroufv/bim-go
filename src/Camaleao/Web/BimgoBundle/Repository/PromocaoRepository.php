<?php

namespace Camaleao\Web\BimgoBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PromocaoRepository extends EntityRepository
{
    /**
     * Find Promocao by Cidade
     * @return mixed
     */
    public function findByCidade($cidade)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:Promocao')
            ->createQueryBuilder('promocao')
            ->innerJoin('promocao.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = $cidade")
            ->andWhere('promocao.publicada = true')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Find Promocao where publicada is true
     * @return mixed
     */
    public function findByPublicada($criteria, $order, $limit, $offset)
    {
        $criteria['publicada'] = true;
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:Promocao')->findBy($criteria, $order, $limit, $offset);

        return $result;
    }
}
