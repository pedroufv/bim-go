<?php

namespace Camaleao\Bimgo\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Instituicao controller.
 */
class InicialController extends Controller
{
    /**
     * homepage
     *
     * @Route(name="admin_inicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('CamaleaoBimgoAdminBundle:inicial:index.html.twig');
    }
}
