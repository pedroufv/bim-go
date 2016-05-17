<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Camaleao\Web\BimgoBundle\Entity\Promocao;
use Camaleao\Web\BimgoBundle\Form\PromocaoType;

/**
 * Promocao controller.
 *
 * @Route("/promocao")
 */
class PromocaoController extends Controller
{
    /**
     * Lists all Promocao entities.
     *
     * @Route("/", name="promocao_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $promocoes = $em->getRepository('CamaleaoWebBimgoBundle:Promocao')->findAll();

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($promocoes, $request->query->get('pagina', 1), 9);

        return $this->render('CamaleaoWebBimgoBundle:promocao:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new Promocao entity.
     *
     * @Route("/new", name="promocao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $promocao = new Promocao();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\PromocaoType', $promocao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promocao);
            $em->flush();

            return $this->redirectToRoute('promocao_show', array('id' => $promocao->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:promocao:new.html.twig', array(
            'promocao' => $promocao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Promocao entity.
     *
     * @Route("/{id}", name="promocao_show")
     * @Method("GET")
     */
    public function showAction(Promocao $promocao)
    {
        $deleteForm = $this->createDeleteForm($promocao);

        return $this->render('CamaleaoWebBimgoBundle:promocao:show.html.twig', array(
            'promocao' => $promocao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Promocao entity.
     *
     * @Route("/{id}/edit", name="promocao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Promocao $promocao)
    {
        $deleteForm = $this->createDeleteForm($promocao);
        $editForm = $this->createForm('Camaleao\Web\BimgoBundle\Form\PromocaoType', $promocao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promocao);
            $em->flush();

            return $this->redirectToRoute('promocao_edit', array('id' => $promocao->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:promocao:edit.html.twig', array(
            'promocao' => $promocao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Promocao entity.
     *
     * @Route("/{id}", name="promocao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Promocao $promocao)
    {
        $form = $this->createDeleteForm($promocao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promocao);
            $em->flush();
        }

        return $this->redirectToRoute('promocao_index');
    }

    /**
     * Creates a form to delete a Promocao entity.
     *
     * @param Promocao $promocao The Promocao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Promocao $promocao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promocao_delete', array('id' => $promocao->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists recent Promocao entities.
     *
     * @Route(name="promocao_recentsection")
     * @Method("GET")
     * @Template()
     */
    public function recentSectionAction($max = 4)
    {
        $em = $this->getDoctrine()->getManager();

        $promocoes = $em->getRepository('CamaleaoWebBimgoBundle:Promocao')->findBy(array('publicada' => true), array('id' => 'DESC'), $max);

        return $this->render('CamaleaoWebBimgoBundle:promocao:recentSection.html.twig', array(
            'promocoes' => $promocoes,
        ));
    }
}
