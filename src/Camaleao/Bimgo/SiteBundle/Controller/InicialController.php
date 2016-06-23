<?php

namespace Camaleao\Bimgo\SiteBundle\Controller;

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

        //dump($body->getContents()); exit;

        //$data = json_decode($body->getContents());

        //$results = json_encode($data->results);

        //dump($body);

        //$body->rewind();

        //* @Type("Doctrine\Common\Collections\ArrayCollection<Camaleao\Bimgo\CoreBundle\Entity\Produto>")


        $serializer = $this->container->get('jms_serializer');
        $result = $serializer->deserialize($body->getContents(), 'Camaleao\Bimgo\CoreBundle\Entity\MetadataResponse', 'json');

        //$obj = \GuzzleHttp\json_decode($body->getContents());

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
