<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Notificacao;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Notificacao controller.
 *
 * @Route("/notificacoes")
 */
class NotificacaoController extends ApiController
{
    /**
     * Lists all Notificacao entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_notificacoes_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Notificacao')->findBy($criteria, $order, $limit, $offset);

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
     * Creates a new Notificacao entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_notificacoes_new")
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

        $notificacao = new Notificacao();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\NotificacaoType', $notificacao, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $push = $this->get('camaleao_bimgo_core.push_notification');

        $data = array(
            'type' => 0,
            'title' => $notificacao->getMensagemtipo()->getNome(),
            'message' => $notificacao->getMensagem(),
            'summary' => $notificacao->getInstituicao()->getNomefantasia(),
        );
        $push->setData($data);

        $push->mountRecipientList($notificacao->getDestinatariotipo());

        $em = $this->getDoctrine()->getManager();
        $notificacao = $em->merge($notificacao);
        $em->flush();

        $responseContent = $serializer->serialize($notificacao, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_notificacoes_show', array('id' => $notificacao->getId()), true));

        return $response;
    }

    /**
     * Get a Notificacao entity
     *
     * @param Notificacao $notificacao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_notificacoes_show")
     * @Method("GET")
     */
    public function showAction(Notificacao $notificacao)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($notificacao, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Notificacao entity.
     *
     * @param Request $request
     * @param Notificacao $notificacao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_notificacoes_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Notificacao $notificacao)
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
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\NotificacaoType', $notificacao, $options);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $notificacao = $em->merge($notificacao);
        $em->flush();

        $responseContent = $serializer->serialize($notificacao, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_notificacoes_show', array('id' => $notificacao->getId()), true));

        return $response;
    }

    /**
     * Delete a Notificacao entity.
     *
     * @param Notificacao $notificacao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_notificacoes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Notificacao $notificacao)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($notificacao);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }

    /**
     * Lists all MensagemTipo entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/mensagens/tipos", name="api_v1_contatos_mensagens_tipos")
     * @Method("GET")
     */
    public function typesOfMessagesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Mensagemtipo')->findBy($criteria, $order, $limit, $offset);

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
     * Lists all DestinarioTipo entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/destinatarios/tipos", name="api_v1_contatos_destinatarios_tipos")
     * @Method("GET")
     */
    public function typesOfRecipientsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Destinatariotipo')->findBy($criteria, $order, $limit, $offset);

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
