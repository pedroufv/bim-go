<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MembroRepository extends EntityRepository
{
    /**
     *
     */
    public function findByGrupo($criteria = array(), $order = array(), $limit = null, $offset = null)
    {
        $result = $this->createQueryBuilder('membro')
            ->innerJoin('membro.instituicao', 'instituicao');

        if(isset($criteria['grupo'])) {
            $result->andWhere("instituicao.grupo = ".$criteria['grupo']);
            unset($criteria['grupo']);
        }

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("membro.$key = $value");
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
    public function findByNotEqualPapel($criteria, $order, $limit, $offset)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->where("membro.papel != ".$criteria['papel']);

        unset($criteria['papel']);

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("membro.$key = $value");
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
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->where("membro.instituicao = $instituicao")
            ->andWhere("membro.papel != $papel")
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
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->where("membro.usuario = $usuario")
            ->andWhere('membro.papel != 1')
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
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->where("membro.instituicao = $instituicao")
            ->andWhere('membro.papel != 1')
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
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->where("membro.instituicao = $instituicao")
            ->andWhere('membro.papel != 1')
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
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->where("membro.usuario = $usuario")
            ->andWhere('membro.papel != 1')
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
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->where("membro.usuario = ".$criteria['usuario'])
            ->andWhere("membro.papel != ".$criteria['papel']);

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
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Membro')
            ->createQueryBuilder('membro')
            ->innerJoin('membro.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria["cidade"]);

        unset($criteria['cidade']);

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("membro.$key = $value");
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
