<?php

namespace Camaleao\Web\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Produto controller.
 *
 * @Route("/produtos")
 */
class ProdutoController extends Controller
{
    /**
     * Lists produto
     *
     * @param Request $request
     * @return Response
     *
     * @Route("", name="api_produtos_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoWebBimgoBundle:Produto')->findBy($criteria, $order, $limit, $offset);

        $metadata = array('resultset' => array('count' => count($list), 'offset' => $offset, 'limit' => $limit));
        $content = array('metadata' => $metadata, 'results' => $list);

        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($content, 'json');

        $response = new Response($result);
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * insert Produto
     *
     * @param Request $request
     * @return Response
     *
     * @Route("", name="api_produtos_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $serializer = $this->container->get('jms_serializer');

        $jsonObject = json_decode($request->get('jsonObject'));
        $jsonData = json_encode($jsonObject->object);
        $produto = $serializer->deserialize($jsonData, 'Camaleao\Web\BimgoBundle\Entity\Produto', 'json');

        $now = new \DateTime();
        $produto->setDatacriado($now);

        $em = $this->getDoctrine()->getManager();
        $produto = $em->merge($produto);
        $em->flush();

        $result = $serializer->serialize($produto, 'json');

        $response = new Response($result);
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
