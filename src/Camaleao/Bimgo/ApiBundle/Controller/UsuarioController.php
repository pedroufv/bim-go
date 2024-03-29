<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Membro;
use Camaleao\Bimgo\CoreBundle\Entity\Seguidor;
use Camaleao\Bimgo\CoreBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Usuario controller.
 *
 * @Route("/usuarios")
 */
class UsuarioController extends ApiController
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

        $message = \Swift_Message::newInstance()
            ->setSubject('Bem vindo ao Bim-go!')
            ->setFrom('cpe.feroz@gmail.com')
            ->setTo($usuario->getEmail())
            ->setBody(
                $this->renderView('CamaleaoBimgoUserBundle:email:new.html.twig', array('usuario' => $usuario)),
                "text/html"
            )
        ;
        $this->get('mailer')->send($message);

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
     * @Route("/{usuario}/instituicoes-seguidas/cidades/{cidade}", name="api_v1_usuarios_instituicoes_seguidas_cidade")
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

    /**
     * List Instituicao entities that user is admin
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/instituicoes-gerenciadas", name="api_v1_usuarios_instituicoes_gerenciadas")
     * @Method("GET")
     */
    public function institutionsManagedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['usuario'] = $request->get('id');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Membro')->findAtivoByGrupo($criteria, $order, $limit, $offset);

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
     * @Route("/verifica-token", name="api_v1_usuarios_verifica_token")
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
     * @Route("/verifica-credenciais", name="api_v1_usuarios_verifica_credenciais")
     * @Method("POST")
     */
    public function checkCredentialsAction(Request $request)
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
     * @Route("/acompanhamento", name="api_v1_usuarios_acompanhamento")
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
     * Creates or Edit Membro entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/membros", name="api_v1_usuarios_membros")
     * @Method("POST")
     */
    public function memberAction(Request $request)
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

        $membro = new Membro();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\MembroType', $membro, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $membro = $em->merge($membro);
        $em->flush();

        $responseContent = $serializer->serialize($membro, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }
}