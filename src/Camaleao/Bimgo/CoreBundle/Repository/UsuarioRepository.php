<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    /**
     * Get user with registrationid is not null
     * @return mixed
     */
    public function findByNotNullRegistrationid()
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Usuario')
            ->createQueryBuilder('usuario')
            ->select('usuario.registrationid')
            ->where('usuario.registrationid IS NOT NULL')
            ->andWhere("usuario.registrationid != ''")
            ->distinct('usuario.registrationid');

        return $result->getQuery()->getResult();
    }
}
