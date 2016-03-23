<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Endereco;
use Camaleao\Web\BimgoBundle\Form\EnderecoType;

/**
 * Endereco controller.
 *
 * @Route("/endereco")
 */
class EnderecoController extends Controller
{
    /**
     * Lists all Endereco entities.
     *
     * @Route("/", name="endereco_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enderecos = $em->getRepository('CamaleaoWebBimgoBundle:Endereco')->findAll();

        return $this->render('CamaleaoWebBimgoBundle:endereco:index.html.twig', array(
            'enderecos' => $enderecos,
        ));
    }

    /**
     * Creates a new Endereco entity.
     *
     * @Route("/new", name="endereco_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $endereco = new Endereco();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\EnderecoType', $endereco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($endereco);
            $em->flush();

            return $this->redirectToRoute('endereco_show', array('id' => $endereco->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:endereco:new.html.twig', array(
            'endereco' => $endereco,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Endereco entity.
     *
     * @Route("/{id}", name="endereco_show")
     * @Method("GET")
     */
    public function showAction(Endereco $endereco)
    {
        $deleteForm = $this->createDeleteForm($endereco);

        return $this->render('CamaleaoWebBimgoBundle:endereco:show.html.twig', array(
            'endereco' => $endereco,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Endereco entity.
     *
     * @Route("/{id}/edit", name="endereco_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Endereco $endereco)
    {
        $deleteForm = $this->createDeleteForm($endereco);
        $editForm = $this->createForm('Camaleao\Web\BimgoBundle\Form\EnderecoType', $endereco);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($endereco);
            $em->flush();

            return $this->redirectToRoute('endereco_edit', array('id' => $endereco->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:endereco:edit.html.twig', array(
            'endereco' => $endereco,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Endereco entity.
     *
     * @Route("/{id}", name="endereco_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Endereco $endereco)
    {
        $form = $this->createDeleteForm($endereco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($endereco);
            $em->flush();
        }

        return $this->redirectToRoute('endereco_index');
    }

    /**
     * Creates a form to delete a Endereco entity.
     *
     * @param Endereco $endereco The Endereco entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Endereco $endereco)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('endereco_delete', array('id' => $endereco->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
