<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Contato;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contato controller.
 *
 * @Route("/contatos")
 */
class ContatoController extends ApiController
{
    /**
     * Lists all Contato entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_contatos_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Contato')->findBy($criteria, $order, $limit, $offset);

        $content = $this->createContent($list, $offset, $limit);

        return $this->responseSuccess($content);
    }

    /**
     * Creates a new Contato entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_contatos_new")
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

        $contato = new Contato();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\ContatoType', $contato, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $contato = $em->merge($contato);
        $em->flush();

        $responseContent = $serializer->serialize($contato, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_contatos_show', array('id' => $contato->getId()), true));

        return $response;
    }

    /**
     * Get a Contato entity
     *
     * @param Contato $contato
     * @return Response
     *
     * @Route("/{id}", name="api_v1_contatos_show")
     * @Method("GET")
     */
    public function showAction(Contato $contato)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($contato, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Contato entity.
     *
     * @param Request $request
     * @param Contato $contato
     * @return Response
     *
     * @Route("/{id}", name="api_v1_contatos_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Contato $contato)
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
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\ContatoType', $contato, $options);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $contato = $em->merge($contato);
        $em->flush();

        $responseContent = $serializer->serialize($contato, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_contatos_show', array('id' => $contato->getId()), true));

        return $response;
    }

    /**
     * Delete a Contato entity.
     *
     * @param Contato $contato
     * @return Response
     *
     * @Route("/{id}", name="api_v1_contatos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Contato $contato)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contato);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }

    /**
     * Lists all ContatoTipo entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route("-tipos", name="api_v1_contatos_tipos")
     * @Method("GET")
     */
    public function typesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Contatotipo')->findBy($criteria, $order, $limit, $offset);

        $content = $this->createContent($list, $offset, $limit);

        return $this->responseSuccess($content);
    }
}
