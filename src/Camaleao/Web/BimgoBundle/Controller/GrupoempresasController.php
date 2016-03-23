<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Grupoempresas;
use Camaleao\Web\BimgoBundle\Form\GrupoempresasType;

/**
 * Grupoempresas controller.
 *
 * @Route("/grupoempresas")
 */
class GrupoempresasController extends Controller
{
    /**
     * Lists all Grupoempresas entities.
     *
     * @Route("/", name="grupoempresas_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $grupoempresas = $em->getRepository('CamaleaoWebBimgoBundle:Grupoempresas')->findAll();

        return $this->render('CamaleaoWebBimgoBundle:grupoempresas:index.html.twig', array(
            'grupoempresas' => $grupoempresas,
        ));
    }

    /**
     * Creates a new Grupoempresas entity.
     *
     * @Route("/new", name="grupoempresas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $grupoempresa = new Grupoempresas();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\GrupoempresasType', $grupoempresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($grupoempresa);
            $em->flush();

            return $this->redirectToRoute('grupoempresas_show', array('id' => $grupoempresa->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:grupoempresas:new.html.twig', array(
            'grupoempresa' => $grupoempresa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Grupoempresas entity.
     *
     * @Route("/{id}", name="grupoempresas_show")
     * @Method("GET")
     */
    public function showAction(Grupoempresas $grupoempresa)
    {
        $deleteForm = $this->createDeleteForm($grupoempresa);

        return $this->render('CamaleaoWebBimgoBundle:grupoempresas:show.html.twig', array(
            'grupoempresa' => $grupoempresa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Grupoempresas entity.
     *
     * @Route("/{id}/edit", name="grupoempresas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Grupoempresas $grupoempresa)
    {
        $deleteForm = $this->createDeleteForm($grupoempresa);
        $editForm = $this->createForm('Camaleao\Web\BimgoBundle\Form\GrupoempresasType', $grupoempresa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($grupoempresa);
            $em->flush();

            return $this->redirectToRoute('grupoempresas_edit', array('id' => $grupoempresa->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:grupoempresas:edit.html.twig', array(
            'grupoempresa' => $grupoempresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Grupoempresas entity.
     *
     * @Route("/{id}", name="grupoempresas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Grupoempresas $grupoempresa)
    {
        $form = $this->createDeleteForm($grupoempresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($grupoempresa);
            $em->flush();
        }

        return $this->redirectToRoute('grupoempresas_index');
    }

    /**
     * Creates a form to delete a Grupoempresas entity.
     *
     * @param Grupoempresas $grupoempresa The Grupoempresas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Grupoempresas $grupoempresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('grupoempresas_delete', array('id' => $grupoempresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
