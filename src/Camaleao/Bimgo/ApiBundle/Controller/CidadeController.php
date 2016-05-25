<?php

namespace Camaleao\Bimgo\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cidade controller.
 *
 * @Route("/cidades")
 */
class CidadeController extends ApiController
{
    /**
     * Lists Cidade
     *
     * @param Request $request
     * @return Response
     *
     * @Route(name="api_v1_cidades_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Cidade')->findBy($criteria, $order, $limit, $offset);

        $content = $this->createContent($list, $offset, $limit);

        return $this->responseSuccess($content);
    }

    /**
     * Lists Instituicao
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/instituicoes", name="api_v1_cidades_instituicoes")
     * @Method("GET")
     */
    public function institutionsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['cidade'] = $request->get('id');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findByCidade($criteria, $order, $limit, $offset);

        $content = $this->createContent($list, $offset, $limit);

        return $this->responseSuccess($content);
    }

    /**
     * Lists Noticacao entities in Cidade entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/notificacoes", name="api_v1_cidades_notificacoes")
     * @Method("GET")
     */
    public function notificationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['cidade'] = $request->get('id');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Notificacao')->findByCidade($criteria, $order, $limit, $offset);

        $content = $this->createContent($list, $offset, $limit);

        return $this->responseSuccess($content);
    }

    /**
     * Lists Produto entities in Cidade entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/produtos", name="api_v1_cidades_produtos")
     * @Method("GET")
     */
    public function productsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['cidade'] = $request->get('id');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Produto')->findByCidade($criteria, $order, $limit, $offset);

        $content = $this->createContent($list, $offset, $limit);

        return $this->responseSuccess($content);
    }

    /**
     * Lists Promocao entities in Cidade entity
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/promocoes", name="api_v1_cidades_promocoes")
     * @Method("GET")
     */
    public function promotionsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        $criteria['cidade'] = $request->get('id');
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Promocao')->findByCidade($criteria, $order, $limit, $offset);

        $content = $this->createContent($list, $offset, $limit);

        return $this->responseSuccess($content);
    }
}
