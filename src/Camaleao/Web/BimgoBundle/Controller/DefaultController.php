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
        return $this->render('CamaleaoWebBimgoBundle:Default:index.html.twig');
    }
}
