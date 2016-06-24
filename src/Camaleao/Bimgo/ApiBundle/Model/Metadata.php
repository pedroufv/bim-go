<?php

namespace Camaleao\Bimgo\ApiBundle\Model;
use JMS\Serializer\Annotation\Type;

class Metadata
{
    /**
     * @var Resultset
     * @Type("Camaleao\Bimgo\ApiBundle\Model\Resultset")
     */
    private $resultset;

    /**
     * Metadata constructor.
     * @param Resultset $resultset
     */
    public function __construct(Resultset $resultset)
    {
        $this->resultset = $resultset;
    }

    /**
     * @return Resultset
     */
    public function getResultset()
    {
        return $this->resultset;
    }

    /**
     * @param Resultset $resultset
     */
    public function setResultset($resultset)
    {
        $this->resultset = $resultset;
    }
}
