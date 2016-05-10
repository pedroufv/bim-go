<?php

namespace Camaleao\Web\BimgoBundle\Entity;

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
            ->select('promocao.id, promocao.nome, promocao.descricao, promocao.datainicio, promocao.datafim')
            ->innerJoin('promocao.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = $cidade")
            ->andWhere('promocao.publicada = true')
            ->getQuery()
            ->getResult();

        return $result;
    }
}
