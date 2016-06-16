<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Membro;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Membro controller.
 *
 * @Route("/membros")
 */
class MembroController extends ApiController
{
    /**
     * List all Membro entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_membros_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Membro')->findBy($criteria, $order, $limit, $offset);

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
     * Creates a new Membro entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_membros_new")
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

        $push = $this->get('camaleao_bimgo_core.push_notification');

        $data = array(
            'type' => 2,
            'title' => 'Permissão concedida',
            'message' => 'Você foi adicionado com permissão de ' . $membro->getPapel()->getNome() . '.',
            'summary' => $membro->getInstituicao()->getNomefantasia(),
        );
        $push->setData($data);

        $registrationIds = array();
        array_push($registrationIds, $membro->getUsuario()->getRegistrationid());

        $push->setRegistrationIds($registrationIds);

        $push->send();

        $responseContent = $serializer->serialize($membro, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }

    /**
     * Edit an existing Membro entity.
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_membros_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request)
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
        $membro = new Membro();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\MembroType', $membro, $options);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $membro = $em->merge($membro);
        $em->flush();

        if ($membro->getAtivo() == false) {
            $push = $this->get('camaleao_bimgo_core.push_notification');

            $data = array(
                'type' => 3,
                'title' => 'Permissão removida',
                'message' => 'Sua permissão de ' . $membro->getPapel()->getNome() . ' foi revogada.',
                'summary' => $membro->getInstituicao()->getNomefantasia(),
            );
            $push->setData($data);

            $registrationIds = array();
            array_push($registrationIds, $membro->getUsuario()->getRegistrationid());

            $push->setRegistrationIds($registrationIds);

            $push->send();
        }

        $responseContent = $serializer->serialize($membro, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }

    /**
     * Delete a Membro entity.
     *
     * @return Response
     *
     * @Route(name="api_v1_membros_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $response = new Response();

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

        $em = $this->getDoctrine()->getManager();
        $membro = $em->getRepository('CamaleaoBimgoCoreBundle:Membro')->findOneBy($requestContent['membro']);

        $em->remove($membro);
        $em->flush();

        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }
}