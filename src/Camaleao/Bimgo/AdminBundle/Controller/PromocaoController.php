<?php

namespace Camaleao\Bimgo\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Camaleao\Bimgo\CoreBundle\Entity\Promocao;

/**
 * Promocao controller.
 *
 * @Route("/promocao")
 */
class PromocaoController extends Controller
{
    /**
     * Lists all Promocao entities.
     *
     * @Route(name="admin_promocao_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $promocoes = $em->getRepository('CamaleaoBimgoCoreBundle:Promocao')->findAll();

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($promocoes, $request->query->get('pagina', 1), 9);

        return $this->render('CamaleaoBimgoSiteBundle:promocao:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Finds and displays a Promocao entity.
     *
     * @Route("/{id}", name="site_promocao_show")
     * @Method("GET")
     */
    public function showAction(Promocao $promocao)
    {
        return $this->render('CamaleaoBimgoSiteBundle:promocao:show.html.twig', array(
            'promocao' => $promocao,
        ));
    }

    /**
     * Lists recent Promocao entities.
     *
     * @Route(name="site_promocao_recentsection")
     * @Method("GET")
     * @Template()
     */
    public function recentSectionAction($max = 4)
    {
        $em = $this->getDoctrine()->getManager();

        $promocoes = $em->getRepository('CamaleaoBimgoCoreBundle:Promocao')->findBy(array('publicada' => true), array('id' => 'DESC'), $max);

        return $this->render('CamaleaoBimgoSiteBundle:promocao:recentSection.html.twig', array(
            'promocoes' => $promocoes,
        ));
    }
}
