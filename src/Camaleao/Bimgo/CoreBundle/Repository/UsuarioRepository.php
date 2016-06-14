<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    /**
     * Get user with registrationid is not null
     * @return mixed
     */

    /**
     * pega os ids de usuarios que tem o aplicativo instalado, todos os usuários do sistema
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

    /**
     * pega os ids de usuarios que tem relação na tabela seguidores com a empresa no parametro
     * seguindo true
     */
    public function findSeguidoresByNotNullRegistrationid($idEmpresa)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->select('usuario.registrationid')
            ->innerJoin('seguidor.usuario', 'usuario')
            ->innerJoin('seguidor.instituicao', 'instituicao')
            ->where('usuario.registrationid IS NOT NULL')
            ->andWhere("usuario.registrationid != ''")
            ->andWhere("seguidor.seguindo = true")
            ->andWhere("instituicao.id = ".$idEmpresa)
            ->distinct('usuario.registrationid');

        return $result->getQuery()->getResult();
    }

    /**
     * pega os ids de usuarios que sao membros administradores de instituicoes em geral,
     * grupos ou empresas, e estao ativos na administracao
     */
    public function findManagerByNotNullRegistrationid()
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->select('usuario.registrationid')
            ->innerJoin('membro.usuario', 'usuario')
            ->innerJoin('membro.papel', 'papel')
            ->where('usuario.registrationid IS NOT NULL')
            ->andWhere("usuario.registrationid != ''")
            ->andWhere("papel.id in (4,7)")
            ->andWhere("membro.ativo", true)
            ->distinct('usuario.registrationid');

        return $result->getQuery()->getResult();
    }

    /**
     * pega os ids de usuarios que sao membros administradores de grupos
     * e estao ativos na administracao
     */
    public function findGroupByNotNullRegistrationid()
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->select('usuario.registrationid')
            ->innerJoin('membro.usuario', 'usuario')
            ->innerJoin('membro.papel', 'papel')
            ->where('usuario.registrationid IS NOT NULL')
            ->andWhere("usuario.registrationid != ''")
            ->andWhere("papel.id", 7)
            ->andWhere("membro.ativo", true)
            ->distinct('usuario.registrationid');

        return $result->getQuery()->getResult();
    }

    /**
     * pega os ids de usuarios que sao membros administradores de empresas
     * e estao ativos na administracao
     */
    public function findEmpresaByNotNullRegistrationid()
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->select('usuario.registrationid')
            ->innerJoin('membro.usuario', 'usuario')
            ->innerJoin('membro.papel', 'papel')
            ->where('usuario.registrationid IS NOT NULL')
            ->andWhere("usuario.registrationid != ''")
            ->andWhere("papel.id", 4)
            ->andWhere("membro.ativo", true)
            ->distinct('usuario.registrationid');

        return $result->getQuery()->getResult();
    }

    /**
     * pega os ids de usuarios que sao membros administradores de empresas
     * associadas e vinculadas a empresa no parametro
     * e estao ativos na administracao
     */
    public function findEmpresaAssociadaByNotNullRegistrationid($idEmpresa)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->select('usuario.registrationid')
            ->innerJoin('membro.usuario', 'usuario')
            ->innerJoin('membro.instituicao', 'instituicao')
            ->innerJoin('membro.papel', 'papel')
            ->where('usuario.registrationid IS NOT NULL')
            ->andWhere("usuario.registrationid != ''")
            ->andWhere("papel.id", 4)
            ->andWhere("membro.ativo", true)
            ->andWhere("instituicao.associada", true)
            ->andWhere("instituicao.vinculada", $idEmpresa)
            ->distinct('usuario.registrationid');

        return $result->getQuery()->getResult();
    }

    /**
     * pega os ids de usuarios que sao membros administradores de empresas
     * não associadas e vinculadas a empresa no parametro
     * e estao ativos na administracao
     */
    public function findEmpresaNaoAssociadaByNotNullRegistrationid($idEmpresa)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->select('usuario.registrationid')
            ->innerJoin('membro.usuario', 'usuario')
            ->innerJoin('membro.instituicao', 'instituicao')
            ->innerJoin('membro.papel', 'papel')
            ->where('usuario.registrationid IS NOT NULL')
            ->andWhere("usuario.registrationid != ''")
            ->andWhere("papel.id", 4)
            ->andWhere("membro.ativo", true)
            ->andWhere("instituicao.associada", false)
            ->andWhere("instituicao.vinculada", $idEmpresa)
            ->distinct('usuario.registrationid');

        return $result->getQuery()->getResult();
    }

    /**
     * pega os ids de usuarios que sao membros em qualquer função
     * e estao ativos como membro da empresa passada como parametro
     */
    public function findMembersByNotNullRegistrationid($idEmpresa)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->select('usuario.registrationid')
            ->innerJoin('membro.usuario', 'usuario')
            ->innerJoin('membro.instituicao', 'instituicao')
            ->where('usuario.registrationid IS NOT NULL')
            ->andWhere("usuario.registrationid != ''")
            ->andWhere("membro.ativo", true)
            ->andWhere("instituicao.associada", false)
            ->andWhere("instituicao.id", $idEmpresa)
            ->distinct('usuario.registrationid');

        return $result->getQuery()->getResult();
    }
}
