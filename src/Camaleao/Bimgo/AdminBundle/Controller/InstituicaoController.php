<?php

namespace Camaleao\Bimgo\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route(name="admin_instituicao_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoBimgoCoreBundle:Instituicao')->findAll();

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($instituicoes, $request->query->get('pagina', 1), 9);

        return $this->render('CamaleaoBimgoAdminBundle:instituicao:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new Instituicao entity.
     *
     * @Route("/new", name="admin_instituicao_new")
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

        return $this->render('CamaleaoBimgoAdminBundle:instituicao:new.html.twig', array(
            'instituicao' => $instituicao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Instituicao entity.
     *
     * @Route("/{id}", name="admin_instituicao_show")
     * @Method("GET")
     */
    public function showAction(Instituicao $instituicao)
    {
        $serializer = $this->container->get('jms_serializer');

        $instituicaoJson = $serializer->serialize($instituicao, 'json');

        return $this->render('CamaleaoBimgoAdminBundle:instituicao:show.html.twig', array(
            'instituicao' => $instituicao,
            'instituicaoJson' => $instituicaoJson
        ));
    }

    /**
     * Displays a form to edit an existing Instituicao entity.
     *
     * @Route("/{id}/edit", name="admin_instituicao_edit")
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

        return $this->render('CamaleaoBimgoAdminBundle:instituicao:edit.html.twig', array(
            'instituicao' => $instituicao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Instituicao entity.
     *
     * @Route("/{id}", name="admin_instituicao_delete")
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
     * List Instituicao entities that user is admin
     *
     * @Route(name="site_instituicao_managed_section")
     * @Method("GET")
     * @Template()
     */
    public function managedSectionAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $criteria = $request->get('criteria') ? $request->get('criteria') : array();
        // recuperar da sessao do usuario logado
        $criteria['usuario'] = 4;
        $criteria['papel'] = 1;
        $order = $request->get('order') ? $request->get('order') : array();
        $limit = $request->get('limit') ? $request->get('limit') : null;
        $offset = $request->get('offset') ? $request->get('offset') : null;

        $list = $em->getRepository('CamaleaoBimgoCoreBundle:Membro')->findByUsuarioAndNotEqualPapel($criteria, $order, $limit, $offset);


        return $this->render('CamaleaoBimgoAdminBundle:instituicao:managedSection.html.twig', array(
            'list' => $list,
        ));
    }
}
