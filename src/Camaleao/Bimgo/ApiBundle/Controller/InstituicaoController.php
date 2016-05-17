<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Instituicao;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cidade controller.
 *
 * @Route("/instituicoes")
 */
class InstituicaoController extends Controller
{
    /**
     * Lists all instituicao entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_instituicoes_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findBy($criteria, $order, $limit, $offset);

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
     * Creates a new Instituicao entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_instituicoes_new")
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
                $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
                return $response;
            }
            $response->headers->set('Content-Type', 'application/json');
            $request->request->replace($requestContent);
        }

        $instituicao = new Instituicao();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\InstituicaoType', $instituicao);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $instituicao = $em->merge($instituicao);
        $em->flush();

        $responseContent = $serializer->serialize($instituicao, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_instituicoes_show', array('id' => $instituicao->getId()), true));

        return $response;
    }

    /**
     * Get a Instituicao entity
     *
     * @param Instituicao $instituicao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_instituicoes_show")
     * @Method("GET")
     */
    public function showAction(Instituicao $instituicao)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($instituicao, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * * Edit an existing Instituicao entity.
     *
     * @param Request $request
     * @param Instituicao $instituicao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_instituicoes_edit")
     * @Method({"PATCH", "PUT"})
     */

    public function editAction(Request $request, Instituicao $instituicao)
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

        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\InstituicaoType', $instituicao, array('method' => $request->getMethod()));
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $instituicao = $em->merge($instituicao);
        $em->flush();

        $responseContent = $serializer->serialize($instituicao, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_instituicoes_show', array('id' => $instituicao->getId()), true));

        return $response;
    }

    /**
     * Delete a Instituicao entity.
     *
     * @param Instituicao $instituicao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_instituicoes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Instituicao $instituicao)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($instituicao);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }

    /**
     * Lists Produto entities in Instituicao entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/produtos", name="api_v1_instituicoes_produtos")
     * @Method("GET")
     */
    public function produtosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['instituicao'] = $request->get('id');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Produto')->findBy($criteria, $order, $limit, $offset);

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
     * Lists Promocao entities in Instituicao entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/promocoes", name="api_v1_instituicoes_promocoes")
     * @Method("GET")
     */
    public function promocoesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['instituicao'] = $request->get('id');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Promocao')->findBy($criteria, $order, $limit, $offset);

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
     * Lists Funcionario entities in Instituicao entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/funcionarios", name="api_v1_instituicoes_funcionarios")
     * @Method("GET")
     */
    public function funcionariosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['instituicao'] = $request->get('id');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Funcionario')->findBy($criteria, $order, $limit, $offset);

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
     * List Usuario entities that are following the institution
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/usuarios-seguidores", name="api_v1_usuarios_usuarios_seguidores")
     * @Method("GET")
     */
    public function usuariosSeguidoresAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['instituicao'] = $request->get('id');
        $criteria['seguindo'] = true;
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:UsuarioInstituicaoPapel')->findBy($criteria, $order, $limit, $offset);

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
