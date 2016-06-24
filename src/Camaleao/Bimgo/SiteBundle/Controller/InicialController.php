<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Model\ApiResponse;
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
    public function indexAction()
    {
        /** @var \GuzzleHttp\Client $client */
        $client   = $this->get('guzzle.client.api_bimgo');
        $response = $client->get('cidades/4082/produtos');
        $body = $response->getBody();
        $body->rewind();

        $apiResponse = new ApiResponse($body->getContents());

        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->deserialize($apiResponse->getJsonResults(), 'Doctrine\Common\Collections\ArrayCollection<Camaleao\Bimgo\CoreBundle\Entity\Produto>', 'json');

        dump($result);
        exit;

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
}
