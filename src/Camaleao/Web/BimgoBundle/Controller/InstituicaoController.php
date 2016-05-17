<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Camaleao\Web\BimgoBundle\Entity\Instituicao;
use Camaleao\Bimgo\CoreBundle\Form\InstituicaoType;

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
     * @Route("/", name="instituicao_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findAll();

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($instituicoes, $request->query->get('pagina', 1), 9);

        return $this->render('CamaleaoWebBimgoBundle:instituicao:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Lists all Instituicao entities.
     *
     * @Route("/segmento/{id}", name="instituicao_segmento")
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

        return $this->render('CamaleaoWebBimgoBundle:instituicao:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Lists all Instituicao entities.
     *
     * @Route("/admin", name="instituicao_indexadmin")
     * @Method("GET")
     */
    public function indexAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM CamaleaoWebBimgoBundle:Instituicao a";
        $instituicaos = $em->createQuery($dql);

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($instituicaos, $request->query->get('pagina', 1), 10);

        return $this->render('CamaleaoWebBimgoBundle:instituicao:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new Instituicao entity.
     *
     * @Route("/new", name="instituicao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $instituicao = new Instituicao();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\InstituicaoType', $instituicao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($instituicao);
            $em->flush();

            return $this->redirectToRoute('instituicao_show', array('id' => $instituicao->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:instituicao:new.html.twig', array(
            'instituicao' => $instituicao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Instituicao entity.
     *
     * @Route("/{id}", name="instituicao_show")
     * @Method("GET")
     */
    public function showAction(Instituicao $instituicao)
    {
        //$deleteForm = $this->createDeleteForm($instituicao);

        $serializer = $this->container->get('jms_serializer');

        $instituicaoJson = $serializer->serialize($instituicao, 'json');

        return $this->render('CamaleaoWebBimgoBundle:instituicao:show.html.twig', array(
            'instituicao' => $instituicao,
            'instituicaoJson' => $instituicaoJson
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Instituicao entity.
     *
     * @Route("/{id}/edit", name="instituicao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Instituicao $instituicao)
    {
        $deleteForm = $this->createDeleteForm($instituicao);
        $editForm = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\InstituicaoType', $instituicao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($instituicao);
            $em->flush();

            return $this->redirectToRoute('instituicao_edit', array('id' => $instituicao->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:instituicao:edit.html.twig', array(
            'instituicao' => $instituicao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Instituicao entity.
     *
     * @Route("/{id}", name="instituicao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Instituicao $instituicao)
    {
        $form = $this->createDeleteForm($instituicao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($instituicao);
            $em->flush();
        }

        return $this->redirectToRoute('instituicao_index');
    }

    /**
     * Creates a form to delete a Instituicao entity.
     *
     * @param Instituicao $instituicao The Instituicao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Instituicao $instituicao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('instituicao_delete', array('id' => $instituicao->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists recent Instituicao entities.
     *
     * @Route(name="instituicao_recent_list")
     * @Method("GET")
     * @Template()
     */
    public function recentListAction($max = 4)
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findBy(array('grupo' => false, 'ativo' => true), array('id' => 'DESC'), $max);

        return $this->render('CamaleaoWebBimgoBundle:instituicao:recentList.html.twig', array(
            'instituicoes' => $instituicoes,
        ));
    }

    /**
     * Lists recent Instituicao entities.
     *
     * @Route(name="instituicao_recent_section")
     * @Method("GET")
     * @Template()
     */
    public function recentSectionAction($max = 4)
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findBy(array('grupo' => false, 'ativo' => true), array('id' => 'DESC'), $max);

        return $this->render('CamaleaoWebBimgoBundle:instituicao:recentSection.html.twig', array(
            'instituicoes' => $instituicoes,
        ));
    }

    /**
     * load instituicaos
     *
     * @Route("/getmapadata", name="instituicao_getmapadata")
     * @Method("POST")
     */
    public function getMapDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $instituicaos = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->getMapData();

        $serializer = $this->container->get('jms_serializer');

        $reports = $serializer->serialize($instituicaos, 'json');

        return new Response($reports);
    }
}
