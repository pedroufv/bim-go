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
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * obter empresas de uma cidade
     * @return mixed
     */
    public function findInstituicaoByCidade($cidade, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:Instituicao')
            ->createQueryBuilder('instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = $cidade");

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
