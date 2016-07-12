<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class InstituicaoRepository extends EntityRepository
{
    /**
     * Get all necessary datas for map
     * @return mixed
     */
    public function getMapData($criteria, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->createQueryBuilder()
            ->select('instituicao.nomefantasia, instituicao.descricao, instituicao.site, endereco.latitude, endereco.longitude')
            ->from('CamaleaoBimgoCoreBundle:Instituicao', 'instituicao')
            ->innerjoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria["cidade"]);

        unset($criteria['cidade']);

        return $result->getQuery()->getResult();
    }

    /**
     * obter empresas de uma cidade
     * @return mixed
     */
    public function findByCidade($criteria, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Instituicao')
            ->createQueryBuilder('instituicao')
            ->leftJoin('instituicao.segmento', 'segmento')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria["cidade"])
            ->groupBy('instituicao.id');

        unset($criteria['cidade']);


        if(isset($criteria['segmento'])) {
            $result->andWhere("segmento.id in (".$criteria['segmento'].")");
            unset($criteria['segmento']);
        }

        if(isset($criteria['segmento_canonico'])) {
            $result->andWhere("segmento.canonico = '".$criteria['segmento_canonico']."'");
            unset($criteria['segmento_canonico']);
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
