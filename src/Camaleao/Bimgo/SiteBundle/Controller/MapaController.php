<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Camaleao\Bimgo\CoreBundle\Entity\Mapa;

/**
 * Mapa controller.
 *
 * @Route("/mapa")
 */
class MapaController extends Controller
{
    /**
     * Lists Instituicao entities in city
     *
     * @Route(name="site_mapa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // recuperar cidade na sessao
        $criteria['cidade'] = 4082;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->getMapData($criteria);

        $serializer = $this->container->get('jms_serializer');

        $reports = $serializer->serialize($list, 'json');

        return new Response($reports);
    }
}
