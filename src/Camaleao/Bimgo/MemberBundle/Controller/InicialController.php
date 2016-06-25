<?php

namespace Camaleao\Bimgo\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InicialController extends Controller
{
    /**
     * homepage
     *
     * @Route(name="member_inicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('CamaleaoBimgoMemberBundle:inicial:index.html.twig');
    }
}
