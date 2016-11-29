<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Client\SenderFCMHelper;
use Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Entity\Message;
use Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Entity\Notification;
use Camaleao\Bimgo\CoreBundle\Entity\Promocao;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Promocao controller.
 *
 * @Route("/promocoes")
 */
class PromocaoController extends ApiController
{
    /**
     * Lists all Promocao entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_promocoes_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Promocao')->findByPublicada($criteria, $order, $limit, $offset);

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
     * Creates a new Promocao entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_promocoes_new")
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

        $promocao = new Promocao();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\PromocaoType', $promocao, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $promocao = $em->merge($promocao);
        $em->flush();

        $responseContent = $serializer->serialize($promocao, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_promocoes_show', array('id' => $promocao->getId()), true));

        return $response;
    }

    /**
     * Get a Promocao entity
     *
     * @param Promocao $promocao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_promocoes_show")
     * @Method("GET")
     */
    public function showAction(Promocao $promocao)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($promocao, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Promocao entity.
     *
     * @param Request $request
     * @param Promocao $promocao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_promocoes_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Promocao $promocao)
    {
        $publicadaAtual = $promocao->getPublicada();

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
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\PromocaoType', $promocao, $options);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $promocao = $em->merge($promocao);
        $em->flush();

        if (!$publicadaAtual AND $promocao->getPublicada()) {
            // SEND FCM NOTIFICATION
            $client = $this->get('camaleao_bimgo_core.sender_fcm');
            $message = new Message();
            $em = $this->getDoctrine()->getManager();
            $registration_ids = SenderFCMHelper::mountRecipientList($em, $promocao->getInstituicao()->getId(), PushNotification::TIPO_DESTINATARIO_SEGUIDORES);
            $message->setRegistrationIds($registration_ids);
            $data = array(
                'type' => 1,
                'title' => $promocao->getNome(),
                'message' => $promocao->getDescricao(),
                'summary' => $promocao->getInstituicao()->getNomefantasia(),
                'id' => $promocao->getId(),
            );
            $message->setData($data);
            $response = $client->send($message);
            dump($response);
            // END
        }

        $responseContent = $serializer->serialize($promocao, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_promocoes_show', array('id' => $promocao->getId()), true));

        return $response;
    }

    /**
     * Delete a Promocao entity.
     *
     * @param Promocao $promocao
     * @return Response
     *
     * @Route("/{id}", name="api_v1_promocoes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Promocao $promocao)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($promocao);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }
}
