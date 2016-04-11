<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EmpresaRepository extends EntityRepository
{
    /**
     * Get all necessary datas for map
     * @return mixed
     */
    public function getMapData()
    {
        $result = $this->getEntityManager()->createQueryBuilder()
            ->select('empresa.nomefantasia, empresa.descricao, empresa.site, endereco.latitude, endereco.longitude')
            ->from('CamaleaoWebBimgoBundle:Empresa', 'empresa')
            ->innerjoin('empresa.endereco', 'endereco')
            ->getQuery()
            ->getResult();

        return $result;
    }

}