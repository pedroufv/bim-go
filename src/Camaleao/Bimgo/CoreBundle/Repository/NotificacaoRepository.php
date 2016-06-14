<?php

namespace Camaleao\Bimgo\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class NotificacaoRepository extends EntityRepository
{

    public function findByCliente($id, $limit = null, $offset = null)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('CamaleaoBimgoCoreBundle:Notificacao', 'n');
        $rsm->addEntityResult('CamaleaoBimgoCoreBundle:Instituicao', 'i');
        $rsm->addEntityResult('CamaleaoBimgoCoreBundle:Usuario', 'u');
        $rsm->addEntityResult('CamaleaoBimgoCoreBundle:Destinatariotipo', 'dt');
        $rsm->addEntityResult('CamaleaoBimgoCoreBundle:Mensagemtipo', 'mt');
        $rsm->addFieldResult('n', 'id', 'id');
        $rsm->addFieldResult('i', 'instituicao', 'id');
        $rsm->addFieldResult('u', 'remetente', 'id');
        $rsm->addFieldResult('n', 'data', 'data');
        $rsm->addFieldResult('dt', 'destinatarioTipo', 'id');
        $rsm->addFieldResult('mt', 'mensagemTipo', 'id');
        $rsm->addFieldResult('n', 'mensagem', 'mensagem');

        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.destinatarioTipo = 1
                UNION ALL
                SELECT n.*
                FROM notificacao n
                  INNER JOIN seguidor s ON s.instituicao = n.instituicao
                  INNER JOIN usuario u ON u.id = s.usuario
                WHERE n.destinatarioTipo = 2
                  AND s.seguindo = true
                  AND u.id = $id";

        if($limit)
            $sql .= "\nLIMIT ".$limit;

        if($offset)
            $sql .= "\nOFFSET ".$offset;

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    public function findByGrupo($id, $instituicao)
    {
        $rsm = new ResultSetMapping();


        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.remetente = $id
                  AND n.instituicao = $instituicao
                UNION ALL
                SELECT n.*
                FROM notificacao n
                  INNER JOIN membro m ON m.instituicao = n.instituicao
                  INNER JOIN usuario u ON u.id = m.usuario
                WHERE n.destinatarioTipo = 3 OR n.destinatarioTipo = 4
                  AND n.instituicao = $instituicao
                  AND m.papel = 7
                  AND m.ativo = true
                  AND u.id = $id";

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    public function findByEmpresa($instituicao)
    {
        $rsm = new ResultSetMapping();


        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.instituicao = $instituicao
                UNION ALL
                SELECT n.*
                FROM notificacao n
                WHERE n.destinatarioTipo = 3
                UNION ALL
                SELECT n.*
                FROM notificacao n
                INNER JOIN instituicao i on i.id = n.instituicao
                WHERE n.destinatarioTipo = 5
                  AND i.grupo = false
                UNION ALL
                SELECT n.*
                FROM notificacao n
                INNER JOIN instituicao i on i.id = n.instituicao
                WHERE n.destinatarioTipo = 6
                  AND i.grupo = false
                  AND i.associada = true
                UNION ALL
                SELECT n.*
                FROM notificacao n
                INNER JOIN instituicao i on i.id = n.instituicao
                WHERE n.destinatarioTipo = 7
                  AND i.grupo = false
                  AND i.associada = false";

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    public function findByMembroGrupo($instituicao)
    {
        $rsm = new ResultSetMapping();


        $sql = "SELECT n.*
                FROM notificacao n
                INNER JOIN instituicao i on i.id = n.instituicao
                WHERE n.instituicao = $instituicao
                  AND n.destinatarioTipo = 8
                  AND i.grupo = true";

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    public function findByMembroEmpresa($instituicao)
    {
        $rsm = new ResultSetMapping();


        $sql = "SELECT n.*
                FROM notificacao n
                WHERE n.instituicao = $instituicao
                  AND n.destinatarioTipo = 5
                  AND i.grupo = false";

        $query = $this->_em->createNativeQuery($sql, $rsm);

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
