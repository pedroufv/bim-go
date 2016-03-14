<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CamaleaoWebBimgoBundle:Default:index.html.twig');
    }
}
