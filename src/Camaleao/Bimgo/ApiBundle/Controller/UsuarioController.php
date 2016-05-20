<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Usuario;
use Camaleao\Bimgo\CoreBundle\Entity\UsuarioInstituicaoPapel;
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

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Usuario')->findBy($criteria, $order, $limit, $offset);

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

        $usuario = new Usuario();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\UsuarioType', $usuario, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->merge($usuario);
        $em->flush();

        $responseContent = $serializer->serialize($usuario, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_usuarios_show', array('id' => $usuario->getId()), true));

        return $response;
    }

    /**
     * Get a Usuario entity
     *
     * @param Usuario $usuario
     * @return Response
     *
     * @Route("/{id}", name="api_v1_usuarios_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($usuario, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Usuario entity.
     *
     * @param Request $request
     * @param Usuario $usuario
     * @return Response
     *
     * @Route("/{id}", name="api_v1_usuarios_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $response = new Response();
        $serializer = $this->container->get('jms_serializer');
        $options = array();

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

        $options['method'] = $request->getMethod();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\UsuarioType', $usuario, $options);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->merge($usuario);
        $em->flush();

        $responseContent = $serializer->serialize($usuario, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_usuarios_show', array('id' => $usuario->getId()), true));

        return $response;
    }

    /**
     * Delete a Usuario entity.
     *
     * @param Usuario $usuario
     * @return Response
     *
     * @Route("/{id}", name="api_v1_usuarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($usuario);
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

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:UsuarioInstituicaoPapel')->findByCidade($criteria, $order, $limit, $offset);

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

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:UsuarioInstituicaoPapel')->findByUsuarioAndNotEqualPapel($criteria, $order, $limit, $offset);

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
     * Check Usuario entity by token
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/check-token", name="api_v1_usuarios_check_token")
     * @Method("POST")
     */
    public function checkTokenAction(Request $request)
    {
        $jsonObject = json_decode($request->getContent());

        $token = $jsonObject->usuario->token;

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('CamaleaoBimgoCoreBundle:Usuario')->findOneBy(array('token' => $token));

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuario, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Check Usuario entity by login and senha
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/check-login", name="api_v1_usuarios_check_login")
     * @Method("POST")
     */
    public function checkLoginAction(Request $request)
    {
        $jsonObject = json_decode($request->getContent());

        $email = $jsonObject->usuario->email;
        $senha = $jsonObject->usuario->senha;

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('CamaleaoBimgoCoreBundle:Usuario')->findOneBy(array('email' => $email, 'senha' => $senha));

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuario, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Creates or Edit UsuarioInstituicaoPapel entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/seguir", name="api_v1_usuarios_follow")
     * @Method("POST")
     */
    public function followAction(Request $request)
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

        $usuarioInstituicaoPapel = new UsuarioInstituicaoPapel();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\UsuarioInstituicaoPapelType', $usuarioInstituicaoPapel, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $usuarioInstituicaoPapel = $em->merge($usuarioInstituicaoPapel);
        $em->flush();

        $responseContent = $serializer->serialize($usuarioInstituicaoPapel, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }
}