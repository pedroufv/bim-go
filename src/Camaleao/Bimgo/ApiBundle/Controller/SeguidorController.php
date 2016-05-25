<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Seguidor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Seguidor controller.
 *
 * @Route("/seguidores")
 */
class SeguidorController extends ApiController
{
    /**
     * List all Seguidor entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_seguidores_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Seguidor')->findBy($criteria, $order, $limit, $offset);

        $metadata = array('resultset' => array('count' => count($list), 'offset' => $offset, 'limit' => $limit));
        $content = array('metadata' => $metadata, 'results' => $list);

        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($content, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Creates a new Seguidor entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_seguidores_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $response = new Response();
        $serializer = $this->container->get('jms_serializer');
        $options = array();

        if(!$request->getContent()){
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $response;
        }

        if($request->getContentType() == 'json') {
            $requestContent = json_decode($request->getContent(), true);
            if(!$requestContent) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                return $response;
            }
            $options = array('csrf_protection' => false);
            $response->headers->set('Content-Type', 'application/json');
            $request->request->replace($requestContent);
        }

        $seguidor = new Seguidor();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\SeguidorType', $seguidor, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $seguidor = $em->merge($seguidor);
        $em->flush();

        $responseContent = $serializer->serialize($seguidor, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }

    /**
     * List Instituicao entities that user is following
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/usuarios/{id}/instituicoes", name="api_v1_seguidores_usuarios_instituicoes")
     * @Method("GET")
     */
    public function institutionsFollowedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['usuario'] = $request->get('id');
        $criteria['seguindo'] = true;
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Seguidor')->findBy($criteria, $order, $limit, $offset);

        $metadata = array('resultset' => array('count' => count($list), 'offset' => $offset, 'limit' => $limit));
        $content = array('metadata' => $metadata, 'results' => $list);

        $array = array();
        $formato = $request->get('format');
        if(isset($formato) AND $formato == 'listids') {
            foreach($list as $item) {
                array_push($array, $item->getInstituicao()->getId());
            }

            $content['results'] = $array;
        }

        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($content, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * List Instituicao entities that user is following in one city
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/usuarios/{usuario}/instituicoes/cidades/{cidade}", name="api_v1_seguidores_usuarios_instituicoes_cidade")
     * @Method("GET")
     */
    public function institutionsFollowedInTheCityAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['usuario'] = $request->get('usuario');
        $criteria['cidade'] = $request->get('cidade');
        $criteria['seguindo'] = true;
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Seguidor')->findByCidade($criteria, $order, $limit, $offset);

        $metadata = array('resultset' => array('count' => count($list), 'offset' => $offset, 'limit' => $limit));
        $content = array('metadata' => $metadata, 'results' => $list);

        $array = array();
        $formato = $request->get('format');
        if(isset($formato) AND $formato == 'listids') {
            foreach($list as $item) {
                array_push($array, $item->getInstituicao()->getId());
            }

            $content['results'] = $array;
        }

        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($content, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}