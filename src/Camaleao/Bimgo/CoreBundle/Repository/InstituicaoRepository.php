<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

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
            ->from('CamaleaoBimgoCoreBundle:Instituicao', 'instituicao')
            ->innerjoin('instituicao.endereco', 'endereco')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * obter empresas de uma cidade
     * @return mixed
     */
    public function findByCidade($criteria, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Instituicao')
            ->createQueryBuilder('instituicao')
            ->innerJoin('instituicao.segmento', 'segmento')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria["cidade"]);

        unset($criteria['cidade']);

        if(isset($criteria['segmento'])) {
            $result->andWhere("segmento.id in (".$criteria['segmento'].")");
            unset($criteria['segmento']);
        }

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
    }
}
