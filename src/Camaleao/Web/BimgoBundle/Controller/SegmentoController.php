<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Segmento;
use Camaleao\Web\BimgoBundle\Form\SegmentoType;

/**
 * Segmento controller.
 *
 * @Route("/segmento")
 */
class SegmentoController extends Controller
{
    /**
     * Lists all Segmento entities.
     *
     * @Route("/", name="segmento_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM CamaleaoWebBimgoBundle:Segmento a";
        $segmentos = $em->createQuery($dql);

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($segmentos, $request->query->get('pagina', 1), 10);

        return $this->render('CamaleaoWebBimgoBundle:segmento:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new Segmento entity.
     *
     * @Route("/new", name="segmento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $segmento = new Segmento();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\SegmentoType', $segmento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($segmento);
            $em->flush();

            return $this->redirectToRoute('segmento_show', array('id' => $segmento->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:segmento:new.html.twig', array(
            'segmento' => $segmento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Segmento entity.
     *
     * @Route("/{id}", name="segmento_show")
     * @Method("GET")
     */
    public function showAction(Segmento $segmento)
    {
        $deleteForm = $this->createDeleteForm($segmento);

        return $this->render('CamaleaoWebBimgoBundle:segmento:show.html.twig', array(
            'segmento' => $segmento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Segmento entity.
     *
     * @Route("/{id}/edit", name="segmento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Segmento $segmento)
    {
        $deleteForm = $this->createDeleteForm($segmento);
        $editForm = $this->createForm('Camaleao\Web\BimgoBundle\Form\SegmentoType', $segmento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($segmento);
            $em->flush();

            return $this->redirectToRoute('segmento_edit', array('id' => $segmento->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:segmento:edit.html.twig', array(
            'segmento' => $segmento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Segmento entity.
     *
     * @Route("/{id}", name="segmento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Segmento $segmento)
    {
        $form = $this->createDeleteForm($segmento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($segmento);
            $em->flush();
        }

        return $this->redirectToRoute('segmento_index');
    }

    /**
     * Creates a form to delete a Segmento entity.
     *
     * @param Segmento $segmento The Segmento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Segmento $segmento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('segmento_delete', array('id' => $segmento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
