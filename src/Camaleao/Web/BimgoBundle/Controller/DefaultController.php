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
     * homepage
     *
     * @Route("/", name="default_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('CamaleaoWebBimgoBundle:default:index.html.twig');
    }
}
