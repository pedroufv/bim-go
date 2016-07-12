<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
        $searchQuery = $request->get('search');

        $finder = $this->container->get('fos_elastica.finder.app.instituicao');
        $instituicoes = $finder->createPaginatorAdapter($searchQuery);

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
     * @Route("/segmento/{canonico}", name="site_instituicao_segmento")
     * @Method("GET")
     */
    public function segmentoAction(Request $request)
    {
        // TODO: refatorar codigo para filtrar pesquisa por segmento
        $searchQuery = $request->get('search');

        if(isset($searchQuery)) {

            $finder = $this->container->get('fos_elastica.finder.app.instituicao');
            $instituicoes = $finder->createPaginatorAdapter($searchQuery);

        } else {

            $em = $this->getDoctrine()->getManager();

            $criteria = $request->get('criteria') ? $request->get('criteria') : array();
            $criteria['segmento_canonico'] = $request->get('canonico');
            // TODO:  recuperar cidade na sessao
            $criteria['cidade'] = 4082;
            $order = $request->get('order') ? $request->get('order') : array();
            $limit = $request->get('limit') ? $request->get('limit') : null;
            $offset = $request->get('offset') ? $request->get('offset') : null;

            $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findByCidade($criteria, $order, $limit, $offset);
        }

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
     * @Route("/{canonico}", name="site_instituicao_show")
     * @ParamConverter("instituicao", class="CamaleaoBimgoCoreBundle:Instituicao")
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
}
