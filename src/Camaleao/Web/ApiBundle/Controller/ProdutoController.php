<?php

namespace Camaleao\Web\ApiBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Produto;
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
        $response = new Response();
        $serializer = $this->container->get('jms_serializer');

        if(!$request->getContent()){
            $response->setStatusCode(400);
            return $response;
        }

        if($request->getContentType() == 'json') {
            $response->headers->set('Content-Type', 'application/json');
            $requestContent = json_decode($request->getContent(), true);
            $request->request->replace($requestContent);
        }

        $produto = new Produto();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\ProdutoType', $produto);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(412);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $produto = $em->merge($produto);
        $em->flush();

        $responseContent = $serializer->serialize($produto, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(201);

        return $response;
    }
}
