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
class NotificacaoController extends Controller
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

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Notificacao')->findByPublicada($criteria, $order, $limit, $offset);

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

        $notificacao = new Notificacao();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\NotificacaoType', $notificacao);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

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

        if($request->getContentType() == 'json') {
            $requestContent = json_decode($request->getContent(), true);
            if(!$requestContent) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                return $response;
            }
            $response->headers->set('Content-Type', 'application/json');
            $request->request->replace($requestContent);
        }

        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\NotificacaoType', $notificacao, array('method' => $request->getMethod()));
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
}
