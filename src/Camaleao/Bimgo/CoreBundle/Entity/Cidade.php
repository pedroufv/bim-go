<?php

namespace Camaleao\Bimgo\CoreBundle\Entity;

use JMS\Serializer\Annotation\Type;

/**
 *  Classe que recebe as repostas em json da api
 */
class MetadataResponse
{
    /**
     * @var array
     * @Type("array")
     */
    private $resultset;

    /**
     * @var array
     * @Type("Doctrine\Common\Collections\ArrayCollection<Camaleao\Bimgo\CoreBundle\Entity\Produto>")
     */
    private $results;

    /**
     * @return array
     */
    public function getResultset()
    {
        return $this->resultset;
    }

    /**
     * @param array $resultset
     */
    public function setResultset($resultset)
    {
        $this->resultset = $resultset;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param array $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }
}
