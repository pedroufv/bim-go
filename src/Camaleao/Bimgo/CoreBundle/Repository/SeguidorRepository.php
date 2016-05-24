<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SeguidorRepository extends EntityRepository
{
    /**
     * Get not equal papel
     * @return mixed
     */
    public function findByNotEqualPapel($criteria, $order, $limit, $offset)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->where("seguidor.papel != ".$criteria['papel']);

        unset($criteria['papel']);

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("seguidor.$key = $value");
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

    /**
     * Get not equal papel
     * @return mixed
     */
    public function findByInstituicaoAndNotEqualPapel($instituicao, $papel)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->where("seguidor.instituicao = $instituicao")
            ->andWhere("seguidor.papel != $papel")
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Encontra todas as instituições que um usuário é seguidor, isto é, exclui papel cliente da pesquisa
     * @return mixed
     */
    public function findInstituicoesPorUsuarioSeguidor($usuario)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->where("seguidor.usuario = $usuario")
            ->andWhere('seguidor.papel != 1')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Encontra todos os usuários seguidor da instituição, isto é, exclui papel cliente da pesquisa
     * @return mixed
     */
    public function findUsuariosSeguidorPorInstituicao($instituicao)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->where("seguidor.instituicao = $instituicao")
            ->andWhere('seguidor.papel != 1')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Encontra intervalo de usuários seguidor da instituição, isto é, exclui papel cliente da pesquisa
     * @return mixed
     */
    public function findUsuariosSeguidorPorInstituicaoLazy($instituicao, $index_inicial, $quantidade)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->where("seguidor.instituicao = $instituicao")
            ->andWhere('seguidor.papel != 1')
            ->setFirstResult($index_inicial)
            ->setMaxResults($quantidade)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Verifica se usuário é seguidor de alguma instituição, isto é, exclui papel cliente da pesquisa
     * @return mixed
     */
    public function findUsuarioEhSeguidorDeAlgumaInstituicao($usuario)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->where("seguidor.usuario = $usuario")
            ->andWhere('seguidor.papel != 1')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }

    /**
     * Get not equal papel
     * @return mixed
     */
    public function findByUsuarioAndNotEqualPapel($criteria, $order, $limit, $offset)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->where("seguidor.usuario = ".$criteria['usuario'])
            ->andWhere("seguidor.papel != ".$criteria['papel']);

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

    /**
     * obter instituicao de um seguidor em uma cidade
     * @return mixed
     */
    public function findByCidade($criteria, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Seguidor')
            ->createQueryBuilder('seguidor')
            ->innerJoin('seguidor.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria["cidade"]);

        unset($criteria['cidade']);

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("seguidor.$key = $value");
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
