<?php

namespace Camaleao\Bimgo\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Bimgo\CoreBundle\Entity\Produto;

/**
 * Produto controller.
 *
 * @Route("/produto")
 */
class ProdutoController extends Controller
{
    /**
     * Lists all Produto entities.
     *
     * @Route(name="admin_produto_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $produtos = $em->getRepository('CamaleaoBimgoCoreBundle:Produto')->findAll();

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($produtos, $request->query->get('pagina', 1), 9);

        return $this->render('CamaleaoBimgoSiteBundle:produto:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Finds and displays a Produto entity.
     *
     * @Route("/{id}", name="site_produto_show")
     * @Method("GET")
     */
    public function showAction(Produto $produto)
    {
        return $this->render('CamaleaoBimgoSiteBundle:produto:show.html.twig', array(
            'produto' => $produto,
        ));
    }
}
