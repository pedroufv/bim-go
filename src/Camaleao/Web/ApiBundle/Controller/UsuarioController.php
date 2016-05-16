<?php

namespace Camaleao\Web\ApiBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Usuario controller.
 *
 * @Route("/usuarios")
 */
class UsuarioController extends Controller
{
    /**
     * List all Usuario entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_usuarios_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoWebBimgoBundle:Usuario')->findBy($criteria, $order, $limit, $offset);

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
     * Creates a new Usuario entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_usuarios_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $response = new Response();
        $serializer = $this->container->get('jms_serializer');

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
            $response->headers->set('Content-Type', 'application/json');
            $request->request->replace($requestContent);
        }

        $produto = new Usuario();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\UsuarioType', $produto);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $produto = $em->merge($produto);
        $em->flush();

        $responseContent = $serializer->serialize($produto, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_usuarios_show', array('id' => $produto->getId()), true));

        return $response;
    }

    /**
     * Get a Usuario entity
     *
     * @param Usuario $produto
     * @return Response
     *
     * @Route("/{id}", name="api_v1_usuarios_show")
     * @Method("GET")
     */
    public function showAction(Usuario $produto)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($produto, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Usuario entity.
     *
     * @param Request $request
     * @param Usuario $produto
     * @return Response
     *
     * @Route("/{id}", name="api_v1_usuarios_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Usuario $produto)
    {
        $response = new Response();
        $serializer = $this->container->get('jms_serializer');

        if($request->getContentType() == 'json') {
            $requestContent = json_decode($request->getContent(), true);
            if(!$requestContent) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                return $response;
            }
            $response->headers->set('Content-Type', 'application/json');
            $request->request->replace($requestContent);
        }

        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\UsuarioType', $produto, array('method' => $request->getMethod()));
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $produto = $em->merge($produto);
        $em->flush();

        $responseContent = $serializer->serialize($produto, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_usuarios_show', array('id' => $produto->getId()), true));

        return $response;
    }

    /**
     * Delete a Usuario entity.
     *
     * @param Usuario $produto
     * @return Response
     *
     * @Route("/{id}", name="api_v1_usuarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Usuario $produto)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($produto);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }

    /**
     * List Instituicao entities that user is following
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/instituicoes-seguidas", name="api_v1_usuarios_instituicoes_seguidas")
     * @Method("GET")
     */
    public function instituicoesSeguidasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['usuario'] = $request->get('id');
        $criteria['seguindo'] = true;
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')->findBy($criteria, $order, $limit, $offset);

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
     * List Instituicao entities that user is following in one city
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{usuario}/instituicoes-seguidas/cidades/{cidade}", name="api_v1_usuarios_instituicoes_seguidas_cidade")
     * @Method("GET")
     */
    public function instituicoesSeguidasCidadeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['usuario'] = $request->get('usuario');
        $criteria['cidade'] = $request->get('cidade');
        $criteria['seguindo'] = true;
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')->findByCidade($criteria, $order, $limit, $offset);

        $metadata = array('resultset' => array('count' => count($list), 'offset' => $offset, 'limit' => $limit));
        $content = array('metadata' => $metadata, 'results' => $list);

        $array = array();
        $formato = $request->get('formato');
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
     * List Instituicao entities that user is admin
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/instituicoes-administradas", name="api_v1_usuarios_instituicoes_administradas")
     * @Method("GET")
     */
    public function instituicoesAdministradasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['usuario'] = $request->get('id');
        $criteria['papel'] = 1;
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')->findByUsuarioAndNotEqualPapel($criteria, $order, $limit, $offset);

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
