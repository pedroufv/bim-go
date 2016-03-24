<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Papel;
use Camaleao\Web\BimgoBundle\Form\PapelType;

/**
 * Papel controller.
 *
 * @Route("/papel")
 */
class PapelController extends Controller
{
    /**
     * Lists all Papel entities.
     *
     * @Route("/", name="papel_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM CamaleaoWebBimgoBundle:Papel a";
        $papeis = $em->createQuery($dql);

        /** @var  $paginator */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($papeis, $request->query->get('pagina', 1), 10);

        return $this->render('CamaleaoWebBimgoBundle:papel:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new Papel entity.
     *
     * @Route("/new", name="papel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $papel = new Papel();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\PapelType', $papel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($papel);
            $em->flush();

            return $this->redirectToRoute('papel_show', array('id' => $papel->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:papel:new.html.twig', array(
            'papel' => $papel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Papel entity.
     *
     * @Route("/{id}", name="papel_show")
     * @Method("GET")
     */
    public function showAction(Papel $papel)
    {
        $deleteForm = $this->createDeleteForm($papel);

        return $this->render('CamaleaoWebBimgoBundle:papel:show.html.twig', array(
            'papel' => $papel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Papel entity.
     *
     * @Route("/{id}/edit", name="papel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Papel $papel)
    {
        $deleteForm = $this->createDeleteForm($papel);
        $editForm = $this->createForm('Camaleao\Web\BimgoBundle\Form\PapelType', $papel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($papel);
            $em->flush();

            return $this->redirectToRoute('papel_edit', array('id' => $papel->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:papel:edit.html.twig', array(
            'papel' => $papel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Papel entity.
     *
     * @Route("/{id}", name="papel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Papel $papel)
    {
        $form = $this->createDeleteForm($papel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($papel);
            $em->flush();
        }

        return $this->redirectToRoute('papel_index');
    }

    /**
     * Creates a form to delete a Papel entity.
     *
     * @param Papel $papel The Papel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Papel $papel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('papel_delete', array('id' => $papel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
