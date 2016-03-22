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

        $reports = $serializer->serialize($array, 'json');

        return new Response($reports, Response::HTTP_OK, array('content-type' => 'application/json') );
    }

    /**
     * insert em estado
     * {"nome":"Clevao","uf":"CC"}
     *
     * @Route("/newestado", name="android_newestado")
     * @Method({"GET", "POST"})
     */
    public function newEstadoAction(Request $request)
    {
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
