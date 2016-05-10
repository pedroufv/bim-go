<?php

namespace Camaleao\Web\ApiBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Promocao;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Promocao controller.
 *
 * @Route("/promocoes")
 */
class PromocaoController extends Controller
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

        $list = $em->getRepository('CamaleaoWebBimgoBundle:Promocao')->findByPublicada($criteria, $order, $limit, $offset);

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

        if(!$request->getContent()){
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $response;
        }

        if($request->getContentType() == 'json') {
            $response->headers->set('Content-Type', 'application/json');
            if($request->getContent()) {
                $requestContent = json_decode($request->getContent(), true);
                $request->request->replace($requestContent);
            }
        }

        $promocao = new Promocao();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\PromocaoType', $promocao);
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
        $response = new Response();
        $serializer = $this->container->get('jms_serializer');

        if($request->getContentType() == 'json') {
            $response->headers->set('Content-Type', 'application/json');
            if($request->getContent()) {
                $requestContent = json_decode($request->getContent(), true);
                $request->request->replace($requestContent);
            }
        }

        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\PromocaoType', $promocao, array('method' => $request->getMethod()));
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
