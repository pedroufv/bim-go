<?php

namespace Camaleao\Bimgo\CoreBundle\Model;

/**
 *  Classe que recebe as repostas em json da api
 */
class ApiResponse
{
    /**
     * @var array
     */
    private $metadata;

    /**
     * @var array
     */
    private $results;

    /**
     * ApiResponse constructor.
     * @param string $jsonResponse
     */
    public function __construct($jsonResponse, $entityClass = null)
    {
        $obj = json_decode($jsonResponse);

        $this->metadata = $obj->metadata;
        $this->results = $obj->results;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return array
     */
    public function getJsonResults()
    {
        return json_encode($this->results);
    }

    /**
     * @param array $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }
}
