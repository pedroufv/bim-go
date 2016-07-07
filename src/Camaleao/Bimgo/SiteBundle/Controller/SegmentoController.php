<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Bimgo\CoreBundle\Entity\Segmento;

/**
 * Segmento controller.
 *
 * @Route("/segmento")
 */
class SegmentoController extends Controller
{
    /**
     * Lists all Segmento entities.
     *
     * @Route(name="site_segmento_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $searchQuery = $request->get('search');

        $finder = $this->container->get('fos_elastica.finder.app.segmento');
        $segmentos = $finder->createPaginatorAdapter($searchQuery);

        /** @var  $paginator */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($segmentos, $request->query->get('pagina', 1), 9);

        return $this->render('CamaleaoBimgoSiteBundle:segmento:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }
}