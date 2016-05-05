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
    public function findByInstituicaoAndNotEqualPapel($instituicao, $papel)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
            ->createQueryBuilder('uip')
            ->where("uip.instituicao = $instituicao")
            ->andWhere("uip.papel != $papel")
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Encontra todas as instituições que um usuário é membro, isto é, exclui papel cliente da pesquisa
     * @return mixed
     */
    public function findInstituicoesPorUsuarioMembro($usuario)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
            ->createQueryBuilder('uip')
            ->where("uip.usuario = $usuario")
            ->andWhere('uip.papel != 1')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Encontra todos os usuários membro da instituição, isto é, exclui papel cliente da pesquisa
     * @return mixed
     */
    public function findUsuariosMembroPorInstituicao($instituicao)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
            ->createQueryBuilder('uip')
            ->where("uip.instituicao = $instituicao")
            ->andWhere('uip.papel != 1')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Encontra intervalo de usuários membro da instituição, isto é, exclui papel cliente da pesquisa
     * @return mixed
     */
    public function findUsuariosMembroPorInstituicaoLazy($instituicao, $index_inicial, $quantidade)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
            ->createQueryBuilder('uip')
            ->where("uip.instituicao = $instituicao")
            ->andWhere('uip.papel != 1')
            ->setFirstResult($index_inicial)
            ->setMaxResults($quantidade)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Verifica se usuário é membro de alguma instituição, isto é, exclui papel cliente da pesquisa
     * @return mixed
     */
    public function findUsuarioEhMembroDeAlgumaInstituicao($usuario)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
            ->createQueryBuilder('uip')
            ->where("uip.usuario = $usuario")
            ->andWhere('uip.papel != 1')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }
}
