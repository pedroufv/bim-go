<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Historico;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Historico controller.
 *
 * @Route("/historicos")
 */
class HistoricoController extends ApiController
{
    /**
     * List all Historico entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_historicos_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Historico')->findBy($criteria, $order, $limit, $offset);

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
     * Creates a new Historico entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_historicos_new")
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

        $historico = new Historico();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\HistoricoType', $historico, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $historico = $em->merge($historico);
        $em->flush();

        $responseContent = $serializer->serialize($historico, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }

    /**
     * List Historico entities of user in one enterprise
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/usuarios/{usuario}/historicos/instituicoes/{instituicao}", name="api_v1_historicos_usuarios_instituicao")
     * @Method("GET")
     */
    public function userHistoricInEnterpriseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['usuario'] = $request->get('usuario');
        $criteria['instituicao'] = $request->get('instituicao');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Historico')->findBy($criteria, $order, $limit, $offset);

        $metadata = array('resultset' => array('count' => count($list), 'offset' => $offset, 'limit' => $limit));
        $content = array('metadata' => $metadata, 'results' => $list);

        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($content, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}