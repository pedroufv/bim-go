<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Estado;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return new JsonResponse($result);
    }

    /**
     * insert em estado
     *
     * @Route("/newestado", name="android_newestado")
     * @Method({"GET", "POST"})
     */
    public function newEstadoAction(Request $request)
    {
        $result = false;
        //$request->isXmlHttpRequest();
        $estado = new Estado();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\EstadoType', $estado);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estado);
            $em->flush();

            $result = true;
        }

        return new JsonResponse(array('result' => $result));
    }
}
