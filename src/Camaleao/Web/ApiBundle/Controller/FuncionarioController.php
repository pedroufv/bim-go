<?php

namespace Camaleao\Web\ApiBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Funcionario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Funcionario controller.
 *
 * @Route("/funcionarios")
 */
class FuncionarioController extends Controller
{
    /**
     * Lists all Funcionario entities
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_funcionarios_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoWebBimgoBundle:Funcionario')->findByPublicada($criteria, $order, $limit, $offset);

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
     * Creates a new Funcionario entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_funcionarios_new")
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

        $funcionario = new Funcionario();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\FuncionarioType', $funcionario);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $funcionario = $em->merge($funcionario);
        $em->flush();

        $responseContent = $serializer->serialize($funcionario, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->generateUrl('api_v1_funcionarios_show', array('id' => $funcionario->getId()), true));

        return $response;
    }

    /**
     * Get a Funcionario entity
     *
     * @param Funcionario $funcionario
     * @return Response
     *
     * @Route("/{id}", name="api_v1_funcionarios_show")
     * @Method("GET")
     */
    public function showAction(Funcionario $funcionario)
    {
        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->serialize($funcionario, 'json');

        $response = new Response($result);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Edit an existing Funcionario entity.
     *
     * @param Request $request
     * @param Funcionario $funcionario
     * @return Response
     *
     * @Route("/{id}", name="api_v1_funcionarios_edit")
     * @Method({"PATCH", "PUT"})
     */
    public function editAction(Request $request, Funcionario $funcionario)
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

        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\FuncionarioType', $funcionario, array('method' => $request->getMethod()));
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::HTTP_PRECONDITION_FAILED);
            $responseContent = $serializer->serialize($form->getErrors(true), 'json');
            $response->setContent($responseContent);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $funcionario = $em->merge($funcionario);
        $em->flush();

        $responseContent = $serializer->serialize($funcionario, 'json');
        $response->setContent($responseContent);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Location', $this->generateUrl('api_v1_funcionarios_show', array('id' => $funcionario->getId()), true));

        return $response;
    }

    /**
     * Delete a Funcionario entity.
     *
     * @param Funcionario $funcionario
     * @return Response
     *
     * @Route("/{id}", name="api_v1_funcionarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Funcionario $funcionario)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($funcionario);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        return $response;
    }
}
