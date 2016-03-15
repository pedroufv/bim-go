<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     *
     *
     * @Route("/", name="default_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('CamaleaoWebBimgoBundle:Empresa')->findAll();

        return $this->render('CamaleaoWebBimgoBundle:Default:index.html.twig', array(
//            'empresas' => $empresas,
        ));
    }
}
