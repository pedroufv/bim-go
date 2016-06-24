<?php

namespace Camaleao\Bimgo\ApiBundle\Service;
use JMS\Serializer\Serializer;

/**
 * Service for api content response
 */
class ContentResponse
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * Response constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * convert content object in json format
     *
     * @param $result
     * @param null $offset
     * @param null $limit
     * @return array
     */
    public function toJson($result, $offset = null, $limit = null)
    {
        if(!$result instanceof \Doctrine\Common\Collections\ArrayCollection) {
            return $this->serializer->serialize($result, 'json');
        }

        $metadata = array('resultset' => array($result->count(), $offset, $limit));

        $content = array('metadata' => $metadata, 'results' => $result);

        return $this->serializer->serialize($content, 'json');
    }

    /**
     * convert content json in object format
     *
     * @param $contentJson
     * @param string $type Exemple: Camaleao\Bimgo\CoreBundle\Entity\EntityName
     * @return mixed
     */
    public function toObject($contentJson, $type = 'Doctrine\\Common\\Collections\\ArrayCollection')
    {
        // se nao eh uma lista de resultados
        $contentObject = json_decode($contentJson);
        if(!isset($contentObject->metadata) AND !isset($contentObject->results))
            return $this->serializer->deserialize($contentJson, $type, 'json');

        $jsonResults = json_encode($contentObject->results);
        $type = "Doctrine\\Common\\Collections\\ArrayCollection<$type>";
        $contentObject->results = $this->serializer->deserialize($jsonResults, $type, 'json');

        return $contentObject;
    }
}