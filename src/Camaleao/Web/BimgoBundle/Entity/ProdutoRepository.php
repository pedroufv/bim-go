<?php

namespace Camaleao\Web\BimgoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProdutoRepository extends EntityRepository
{
    /**
     * Get Estados participantes
     * @return mixed
     */
    public function findByCidade($cidade)
    {
        $result = $this->getEntityManager()->getRepository('CamaleaoWebBimgoBundle:Produto')
            ->createQueryBuilder('produto')
            ->select('produto.id, produto.nome, produto.preco, produto.ean, produto.datacriado, produto.datamodificacao')
            ->innerJoin('produto.instituicao', 'instituicao')
            ->innerJoin('instituicao.endereco', 'endereco')
            ->innerJoin('endereco.cidade', 'cidade')
            ->where("cidade.id = $cidade")
            ->getQuery()
            ->getResult();

        return $result;
    }
}
