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
     * load empresas for android
     *
     * @Route("/getestados", name="android_getestados")
     * @Method({"GET", "POST"})
     */
    public function getEstadosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $estados = $em->getRepository('CamaleaoWebBimgoBundle:Estado')->findAll();

        $serializer = $this->container->get('jms_serializer');

        $reports = $serializer->serialize($estados, 'json');

        return new Response($reports);
    }
}
