<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class NotificacaoRepository extends EntityRepository
{

    public function findByCliente($usuario, $criteria = null, $limit = null, $offset = null)
    {
        $cidade = $criteria['cidade'];

        $result = $this->createQueryBuilder('notificacao')
            ->innerJoin('notificacao.instituicao', 'instituicao')
            ->innerJoin('CamaleaoBimgoCoreBundle:Seguidor', 'seguidor', 'WITH','instituicao.id = seguidor.instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->where("notificacao.destinatariotipo = 1")
            ->orWhere("notificacao.destinatariotipo = 2 AND seguidor.usuario = $usuario AND seguidor.seguindo = true AND endereco.cidade = $cidade")
            ->orderBy('notificacao.id', 'DESC');

        if($offset)
            $result->setFirstResult($offset);

        if($limit)
            $result->setMaxResults($limit);

        return $result->getQuery()->getResult();
    }

    public function findByGrupo($instituicao, $limit = null, $offset = null)
    {
        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.instituicao = $instituicao
                  OR (n.destinatarioTipo = 3 OR n.destinatarioTipo = 4)
				ORDER BY id DESC";

        if($limit)
            $sql .= "\nLIMIT ".$limit;

        if($offset)
            $sql .= "\nOFFSET ".$offset;

        $query = $this->_em->createQuery($sql);

        return $query->getResult();
    }

    public function findByEmpresaAssociada($instituicao, $limit = null, $offset = null)
    {
        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.instituicao = $instituicao
                  OR (n.destinatarioTipo = 3 OR n.destinatarioTipo = 5 OR n.destinatarioTipo = 6)
				ORDER BY id DESC";

        if($limit)
            $sql .= "\nLIMIT ".$limit;

        if($offset)
            $sql .= "\nOFFSET ".$offset;

        $query = $this->_em->createQuery($sql);

        return $query->getResult();
    }

    public function findByEmpresaNaoAssociada($instituicao, $limit = null, $offset = null)
    {
        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.instituicao = $instituicao
                  OR (n.destinatarioTipo = 3 OR n.destinatarioTipo = 5 OR n.destinatarioTipo = 7)
				ORDER BY id DESC";

        if($limit)
            $sql .= "\nLIMIT ".$limit;

        if($offset)
            $sql .= "\nOFFSET ".$offset;

        $query = $this->_em->createQuery($sql);

        return $query->getResult();
    }

    public function findByMembroGrupo($instituicao, $limit = null, $offset = null)
    {
        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.instituicao = $instituicao
                  AND n.destinatarioTipo = 8
				ORDER BY id DESC";

        if($limit)
            $sql .= "\nLIMIT ".$limit;

        if($offset)
            $sql .= "\nOFFSET ".$offset;

        $query = $this->_em->createQuery($sql);

        return $query->getResult();
    }

    public function findByMembroEmpresa($instituicao, $limit = null, $offset = null)
    {
        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.instituicao = $instituicao
                  AND n.destinatarioTipo = 8
				ORDER BY id DESC";

        if($limit)
            $sql .= "\nLIMIT ".$limit;

        if($offset)
            $sql .= "\nOFFSET ".$offset;

        $query = $this->_em->createQuery($sql);

        return $query->getResult();
    }

    /**
     * Get Notificaco entities by Cidade
     * @return mixed
     */
    public function findByCidade($criteria, $order = array(), $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoBimgoCoreBundle:Notificacao')
            ->createQueryBuilder('notificacao')
            ->innerJoin('notificacao.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = ".$criteria['cidade']);

        unset($criteria['cidade']);

        if(count($criteria) > 0) {
            foreach($criteria as $key => $value) {
                $result->andWhere("notificacao.$key = $value");
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
