<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route(name="site_produto_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $searchQuery = $request->get('search');

        $finder = $this->container->get('fos_elastica.finder.app.produto');
        $produtos = $finder->createPaginatorAdapter($searchQuery);

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
     * @Route("/{canonico}", name="site_produto_show")
     * @ParamConverter("produto", class="CamaleaoBimgoCoreBundle:Produto")
     * @Method("GET")
     */
    public function showAction(Produto $produto)
    {
        return $this->render('CamaleaoBimgoSiteBundle:produto:show.html.twig', array(
            'produto' => $produto,
        ));
    }
}
