<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InicialController extends Controller
{
    /**
     * homepage
     *
     * @Route(name="inicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('CamaleaoBimgoSiteBundle:inicial:index.html.twig');
    }
}
