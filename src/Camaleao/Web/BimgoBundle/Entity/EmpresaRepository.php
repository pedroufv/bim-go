<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EmpresaRepository extends EntityRepository
{
    /**
     * Get all necessary datas for map
     * @return mixed
     */
    public function getMapDatas()
    {
        $result = $this->getEntityManager()->createQueryBuilder()
            ->select('empresa.nomefantasia, empresa.descricao, empresa.telefone, endereco.latitude, endereco.longitude')
            ->from('CamaleaoWebBimgoBundle:Empresa', 'empresa')
            ->innerjoin('empresa.endereco', 'endereco')
            ->getQuery()
            ->getResult();

        return $result;
    }

}