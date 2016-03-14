<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Cidade;
use Camaleao\Web\BimgoBundle\Form\CidadeType;

/**
 * Cidade controller.
 *
 * @Route("/cidade")
 */
class CidadeController extends Controller
{
    /**
     * Lists all Cidade entities.
     *
     * @Route("/", name="cidade_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cidades = $em->getRepository('CamaleaoWebBimgoBundle:Cidade')->findAll();

        return $this->render('cidade/index.html.twig', array(
            'cidades' => $cidades,
        ));
    }

    /**
     * Creates a new Cidade entity.
     *
     * @Route("/new", name="cidade_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cidade = new Cidade();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\CidadeType', $cidade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cidade);
            $em->flush();

            return $this->redirectToRoute('cidade_show', array('id' => $cidade->getId()));
        }

        return $this->render('cidade/new.html.twig', array(
            'cidade' => $cidade,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cidade entity.
     *
     * @Route("/{id}", name="cidade_show")
     * @Method("GET")
     */
    public function showAction(Cidade $cidade)
    {
        $deleteForm = $this->createDeleteForm($cidade);

        return $this->render('cidade/show.html.twig', array(
            'cidade' => $cidade,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cidade entity.
     *
     * @Route("/{id}/edit", name="cidade_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cidade $cidade)
    {
        $deleteForm = $this->createDeleteForm($cidade);
        $editForm = $this->createForm('Camaleao\Web\BimgoBundle\Form\CidadeType', $cidade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cidade);
            $em->flush();

            return $this->redirectToRoute('cidade_edit', array('id' => $cidade->getId()));
        }

        return $this->render('cidade/edit.html.twig', array(
            'cidade' => $cidade,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cidade entity.
     *
     * @Route("/{id}", name="cidade_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cidade $cidade)
    {
        $form = $this->createDeleteForm($cidade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cidade);
            $em->flush();
        }

        return $this->redirectToRoute('cidade_index');
    }

    /**
     * Creates a form to delete a Cidade entity.
     *
     * @param Cidade $cidade The Cidade entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cidade $cidade)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cidade_delete', array('id' => $cidade->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
