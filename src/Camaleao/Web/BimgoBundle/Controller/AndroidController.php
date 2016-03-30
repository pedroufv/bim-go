<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Estado;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Empresa;

/**
 * Android controller.
 *
 * @Route("/android")
 */
class AndroidController extends Controller
{
    /**
     *  select em usuarios
     *
     * @Route("/checktoken", name="android_checktoken")
     * @Method({"GET", "POST"})
     */
    public function checkTokenAction(Request $request)
    {
        //$jsonObject = json_decode($request->get('jsonObject'));

        $token = $request->get('token');



        //$usuario = new Usuario();
        //$usuario->setToken(jsonObject->usuario->token);
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('CamaleaoWebBimgoBundle:Usuario')->findOneBy(array('token' => $token));

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuario, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));

//        return new Response(json_encode(array('result' => $usuario)), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em estados
     *
     * @Route("/getestados", name="android_getestados")
     * @Method({"GET", "POST"})
     */
    public function getEstadosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $estados = $em->getRepository('CamaleaoWebBimgoBundle:Estado')->findAll();

        $array = array('estados' => $estados);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em empresas
     *
     * @Route("/getempresas", name="android_getempresas")
     * @Method({"GET", "POST"})
     */
    public function getEmpresasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('CamaleaoWebBimgoBundle:Empresa')->findAll();

        $array = array('empresas' => $empresas);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * insert em estado
     *
     * @Route("/newestado", name="android_newestado")
     * @Method("POST")
     */
    public function newEstadoAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $estado = new Estado();
        $estado->setNome($jsonObject->estado->nome);
        $estado->setUf($jsonObject->estado->uf);

        $em = $this->getDoctrine()->getManager();
        $em->persist($estado);
        $em->flush();

        return new Response(json_encode(array('result' => $estado->getId())), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * dispara o insert
     *
     * @Route("/gatilhos", name="android_gatilhos")
     * @Method({"GET", "POST"})
     */
    public function gatilhosAction()
    {
        return $this->render('CamaleaoWebBimgoBundle:android:index.html.twig');
    }
}