<?php

namespace Camaleao\Web\BimgoBundle\Controller;

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
     * load empresas for android
     *
     * @Route("/getempresas", name="android_getempresas")
     * @Method("POST")
     */
    public function getEmpresasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('CamaleaoWebBimgoBundle:Empresa')->findAll();

        $serializer = $this->container->get('jms_serializer');

        $reports = $serializer->serialize($empresas, 'json');

        return new Response($reports);
    }

    /**
     * load empresas for android
     *
     * @Route("/getempresas", name="android_getempresas")
     * @Method("POST")
     */
    public function setEmpresaAction(Request $request)
    {
        // recupera parametros
        $params = $request->getParams();

        // instancia o a entidade empresa
        $empresa = new Empresa();

        // popula a entidade
        $empresa->bind($params['empresa']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($empresa);
        $em->flush();

        $return = json_encode(array('result' => true));

        return new Response($return);
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

        //dump($estados);

        $array = array('estados' => $estados);

        $json = json_encode($array);

        //dump($json);



        $serializer = $this->container->get('jms_serializer');



        $reports = $serializer->serialize($array, 'json');

        dump($reports);

        return new Response($reports, Response::HTTP_OK, array('content-type' => 'application/json') );
    }

    /**
     * insert em estado
     *  {"nome":"Clevao","uf":"CC"}
     *
     * @Route("/newestado", name="android_newestado")
     * @Method({"GET", "POST"})
     */
    public function newEstadoAction(Request $request)
    {
        $response =  new Response($request, Response::HTTP_OK, array('content-type' => 'application/json') );

        $response->send();

        dump($response); exit;

        $estado = new Estado();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\EstadoType', $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estado);
            $em->flush();

            return $this->redirectToRoute('estado_show', array('id' => $estado->getId()));
        }

        $return = json_encode(array('result' => true));

        return new Response($return);
    }
}
