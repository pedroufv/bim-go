<?php

namespace Camaleao\Bimgo\ApiBundle\Service;
use Camaleao\Bimgo\ApiBundle\Model\Content;
use Camaleao\Bimgo\ApiBundle\Model\Metadata;
use Camaleao\Bimgo\ApiBundle\Model\Resultset;
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
     * builds the content unserialize for return with resultset and metadata
     *
     * @param $result
     * @param string $format
     * @param null $offset
     * @param null $limit
     * @return array
     */
    public function buildContent($result, $format = 'json', $offset = null, $limit = null)
    {
        if(!$result instanceof \Doctrine\Common\Collections\ArrayCollection) {
            return $this->serializer->serialize($result, $format);
        }

        $resultset = new Resultset($result->count(), $offset, $limit);
        $metadata = new Metadata($resultset);
        $content = new Content($metadata, $result);

        return $this->serializer->serialize($content, $format);
    }

    public function jsonResults2ArrayCollection($contentJson, $resultsType = '')
    {
        $contentObject = json_decode($contentJson);
        $jsonResults = json_encode($contentObject->results);

        $entityType = '';
        if(!empty($resultsType)) {
            $entityType .= "<".$resultsType.">";
        }

        $type = "Doctrine\\Common\\Collections\\ArrayCollection".$entityType;
        $contentObject->results = $this->serializer->deserialize($jsonResults, $type, 'json');

        return $contentObject;
    }

}