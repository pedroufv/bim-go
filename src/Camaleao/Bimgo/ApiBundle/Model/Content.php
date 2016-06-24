<?php

namespace Camaleao\Bimgo\ApiBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class Content
{
    /**
     * @var Metadata
     * @Type("Camaleao\Bimgo\ApiBundle\Model\Metadata")
     */
    private $metadata;

    /**
     * @var ArrayCollection
     * @Type("ArrayCollection<$T>")
     */
    private $results;

    /**
     * Content constructor.
     * @param Metadata $metadata
     * @param ArrayCollection $results
     */
    public function __construct(Metadata $metadata, ArrayCollection $results)
    {
        $this->metadata = $metadata;
        $this->results = $results;
    }

    /**
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param Metadata $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return ArrayCollection
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param ArrayCollection $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }
}
