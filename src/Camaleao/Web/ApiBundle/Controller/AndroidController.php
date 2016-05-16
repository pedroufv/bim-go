<?php

namespace Camaleao\Web\ApiBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Android;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Android controller.
 *
 * @Route("/androids")
 */
class AndroidController extends Controller
{
    /**
     * Lists all Android entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_androids_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoWebBimgoBundle:Android')->findByPublicada($criteria, $order, $limit, $offset);

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
     * Creates a new Android entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_androids_new")
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

        $android = new Android();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\AndroidType', $android);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $android = $em->merge($android);
        $em->flush();

        $responseContent = $serializer->serialize($android, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_androids_show', array('id' => $android->getId()), true));

        return $response;
    }

    /**
     * Get a Android entity
     *
     * @param Android $android
     * @return Response
     *
     * @Route("/{id}", name="api_v1_androids_show")
     * @Method("GET")
     */
    public function showAction(Android $android)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($android, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Android entity.
     *
     * @param Request $request
     * @param Android $android
     * @return Response
     *
     * @Route("/{id}", name="api_v1_androids_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Android $android)
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

        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\AndroidType', $android, array('method' => $request->getMethod()));
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $android = $em->merge($android);
        $em->flush();

        $responseContent = $serializer->serialize($android, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_androids_show', array('id' => $android->getId()), true));

        return $response;
    }

    /**
     * Delete a Android entity.
     *
     * @param Android $android
     * @return Response
     *
     * @Route("/{id}", name="api_v1_androids_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Android $android)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($android);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }
}
