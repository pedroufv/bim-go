<?php

namespace Camaleao\Bimgo\CustomerBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InicialController extends Controller
{
    /**
     * homepage
     *
     * @Route(name="customer_inicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('CamaleaoBimgoCustomerBundle:inicial:index.html.twig');
    }
}
