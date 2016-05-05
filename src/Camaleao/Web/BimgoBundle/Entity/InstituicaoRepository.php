<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class InstituicaoRepository extends EntityRepository
{
    /**
     * Get all necessary datas for map
     * @return mixed
     */
    public function getMapData()
    {
        $result = $this->getEntityManager()->createQueryBuilder()
            ->select('instituicao.nomefantasia, instituicao.descricao, instituicao.site, endereco.latitude, endereco.longitude')
            ->from('CamaleaoWebBimgoBundle:Instituicao', 'instituicao')
            ->innerjoin('instituicao.endereco', 'endereco')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * obter empresas de determinado segmento
     * @return mixed
     */
    public function getInstituicaoBySegmento($id)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:Instituicao')
            ->createQueryBuilder('instituicao')
            ->innerJoin('instituicao.segmento', 'segmento')
            ->where("segmento.id = $id")
            ->setFirstResult($index_inicial)
            ->setMaxResults($quantidade)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * obter empresas de uma cidade
     * @return mixed
     */
    public function findInstituicaoByCidade($cidade)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:Instituicao')
            ->createQueryBuilder('instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = $cidade")
            ->getQuery()
            ->getResult();

        return $result;
    }
}
