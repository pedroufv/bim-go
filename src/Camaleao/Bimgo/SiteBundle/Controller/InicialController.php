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
        // recuperar cidade na sessao
        $cidade = 4082;

        /** @var \GuzzleHttp\Client $client */
        $client   = $this->get('guzzle.client.api_bimgo');
        $response = $client->get("cidades/$cidade/instituicoes");
        $body = $response->getBody();
        $body->rewind();

        //$content = $this->get('camaleao_bimgo_api.content_response')->toObject($body->getContents(), 'Camaleao\Bimgo\CoreBundle\Entity\Instituicao');

        return new Response($body->getContents());
    }
}
