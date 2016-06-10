<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Oferta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Oferta controller.
 *
 * @Route("/ofertas")
 */
class OfertaController extends ApiController
{
    /**
     * Lists all Oferta entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_ofertas_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Oferta')->findBy($criteria, $order, $limit, $offset);

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
     * Creates a new Oferta entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_ofertas_new")
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

        $oferta = new Oferta();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\OfertaType', $oferta, $options);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $oferta = $em->merge($oferta);
        $em->flush();

        $responseContent = $serializer->serialize($oferta, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_ofertas_show', array('id' => $oferta->getId()), true));

        return $response;
    }

    /**
     * Get a Oferta entity
     *
     * @param Oferta $oferta
     * @return Response
     *
     * @Route("/{id}", name="api_v1_ofertas_show")
     * @Method("GET")
     */
    public function showAction(Oferta $oferta)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($oferta, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Oferta entity.
     *
     * @param Request $request
     * @param Oferta $oferta
     * @return Response
     *
     * @Route("/{id}", name="api_v1_ofertas_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Oferta $oferta)
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
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\OfertaType', $oferta, $options);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $oferta = $em->merge($oferta);
        $em->flush();

        $responseContent = $serializer->serialize($oferta, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_ofertas_show', array('id' => $oferta->getId()), true));

        return $response;
    }

    /**
     * Delete a Oferta entity.
     *
     * @param Oferta $oferta
     * @return Response
     *
     * @Route("/{id}", name="api_v1_ofertas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Oferta $oferta)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($oferta);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }
}
