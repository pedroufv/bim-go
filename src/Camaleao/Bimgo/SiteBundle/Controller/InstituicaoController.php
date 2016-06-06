<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Camaleao\Bimgo\CoreBundle\Entity\Instituicao;

/**
 * Instituicao controller.
 *
 * @Route("/instituicao")
 */
class InstituicaoController extends Controller
{
    /**
     * Lists all Instituicao entities.
     *
     * @Route(name="site_instituicao_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findAll();

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($instituicoes, $request->query->get('pagina', 1), 9);

        return $this->render('CamaleaoBimgoSiteBundle:instituicao:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Lists all Instituicao entities.
     *
     * @Route("/segmento/{id}", name="site_instituicao_segmento")
     * @Method("GET")
     */
    public function segmentoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $segmentoId = $request->attributes->get('id');

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->getInstituicaoBySegmento($segmentoId);

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($instituicoes, $request->query->get('pagina', 1), 9);

        return $this->render('CamaleaoBimgoSiteBundle:instituicao:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Finds and displays a Instituicao entity.
     *
     * @Route("/{id}", name="site_instituicao_show")
     * @Method("GET")
     */
    public function showAction(Instituicao $instituicao)
    {
        $serializer = $this->container->get('jms_serializer');

        $instituicaoJson = $serializer->serialize($instituicao, 'json');

        return $this->render('CamaleaoBimgoSiteBundle:instituicao:show.html.twig', array(
            'instituicao' => $instituicao,
            'instituicaoJson' => $instituicaoJson
        ));
    }

    /**
     * Lists recent Instituicao entities.
     *
     * @Route(name="site_instituicao_recent_list")
     * @Method("GET")
     * @Template()
     */
    public function recentListAction($max = 4)
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findBy(array('grupo' => false, 'ativo' => true), array('id' => 'DESC'), $max);

        return $this->render('CamaleaoBimgoSiteBundle:instituicao:recentList.html.twig', array(
            'instituicoes' => $instituicoes,
        ));
    }

    /**
     * Lists recent Instituicao entities.
     *
     * @Route(name="site_instituicao_recent_section")
     * @Method("GET")
     * @Template()
     */
    public function recentSectionAction($max = 4)
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findBy(array('grupo' => false, 'ativo' => true), array('id' => 'DESC'), $max);

        return $this->render('CamaleaoBimgoSiteBundle:instituicao:recentSection.html.twig', array(
            'instituicoes' => $instituicoes,
        ));
    }

    /**
     * load instituicaos
     *
     * @Route("/mapa/data", name="site_instituicao_getmapdata")
     * @Method("GET")
     */
    public function getMapDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->getMapData();

        $serializer = $this->container->get('jms_serializer');

        $reports = $serializer->serialize($instituicoes, 'json');

        return new Response($reports);
    }
}
