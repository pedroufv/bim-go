<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Endereco;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Endereco controller.
 *
 * @Route("/enderecos")
 */
class EnderecoController extends Controller
{
    /**
     * Lists all Endereco entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_enderecos_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Endereco')->findByPublicada($criteria, $order, $limit, $offset);

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
     * Creates a new Endereco entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_enderecos_new")
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

        $endereco = new Endereco();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\EnderecoType', $endereco);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $endereco = $em->merge($endereco);
        $em->flush();

        $responseContent = $serializer->serialize($endereco, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_enderecos_show', array('id' => $endereco->getId()), true));

        return $response;
    }

    /**
     * Get a Endereco entity
     *
     * @param Endereco $endereco
     * @return Response
     *
     * @Route("/{id}", name="api_v1_enderecos_show")
     * @Method("GET")
     */
    public function showAction(Endereco $endereco)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($endereco, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Endereco entity.
     *
     * @param Request $request
     * @param Endereco $endereco
     * @return Response
     *
     * @Route("/{id}", name="api_v1_enderecos_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Endereco $endereco)
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

        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\EnderecoType', $endereco, array('method' => $request->getMethod()));
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $endereco = $em->merge($endereco);
        $em->flush();

        $responseContent = $serializer->serialize($endereco, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_enderecos_show', array('id' => $endereco->getId()), true));

        return $response;
    }

    /**
     * Delete a Endereco entity.
     *
     * @param Endereco $endereco
     * @return Response
     *
     * @Route("/{id}", name="api_v1_enderecos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Endereco $endereco)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($endereco);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }
}
