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

}