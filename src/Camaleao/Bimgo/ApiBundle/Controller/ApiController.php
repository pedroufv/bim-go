<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * interface api controller.
 */
class ApiController extends Controller
{

    /**
     * builds the content unserialize for return with resultset and metadata
     *
     * @param $list
     * @param null $offset
     * @param null $limit
     * @return array
     */
    public function createContent($list, $offset = null, $limit = null)
    {
        $metadata = array('resultset' => array('count' => count($list), 'offset' => $offset, 'limit' => $limit));
        $content = array('metadata' => $metadata, 'results' => $list);

        return $content;
    }

    /**
     * Serialize content and return code 200
     *
     * @param $content
     * @return Response
     */
    public function responseSuccess($content)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($content, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
