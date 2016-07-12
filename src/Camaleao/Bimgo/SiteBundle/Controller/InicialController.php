<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Instituicao;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InicialController extends Controller
{
    /**
     * homepage
     *
     * @Route(name="site_inicial_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('CamaleaoBimgoSiteBundle:inicial:index.html.twig');
    }

    /**
     * Lists Instituicao entities in city
     *
     * @Route("/mapa", name="site_mapa_index")
     * @Method("GET")
     */
    public function mapaAction()
    {
        $em = $this->getDoctrine()->getManager();

        // recuperar cidade na sessao
        $criteria['cidade'] = 4082;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->getMapData($criteria);

        $serializer = $this->container->get('jms_serializer');

        $reports = $serializer->serialize($list, 'json');

        return new Response($reports);
    }

    /**
     *
     * @Route("/canonico-segmento", name="site_cononico_segmento_index")
     * @Method("GET")
     */
    public function canonicoSegmentoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Segmento')->findAll();

        foreach($list as $item) {
            $item->setAtivo(1);
            $em->persist($item);
        }

        $em->flush();

        return $this->render('CamaleaoBimgoSiteBundle:inicial:index.html.twig');
    }
}
