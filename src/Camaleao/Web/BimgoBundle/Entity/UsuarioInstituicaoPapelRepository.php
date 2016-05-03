<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioInstituicaoPapelRepository extends EntityRepository
{
    /**
     * Get not equal papel
     * @return mixed
     */
    public function findByNotEqualPapel($papel)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
            ->createQueryBuilder('uip')
            ->where("uip.papel != $papel")
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Get not equal papel
     * @return mixed
     */
    public function findbyInstituicaoAndNotEqualPapel($instituicao, $papel)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
            ->createQueryBuilder('uip')
            ->where("uip.instituicao = $instituicao")
            ->andwhere("uip.papel != $papel")
            ->getQuery()
            ->getResult();

        return $result;
    }
}
