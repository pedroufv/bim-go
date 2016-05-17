<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Pagamento;
use Camaleao\Bimgo\CoreBundle\Form\PagamentoType;

/**
 * Pagamento controller.
 *
 * @Route("/pagamento")
 */
class PagamentoController extends Controller
{
    /**
     * Lists all Pagamento entities.
     *
     * @Route("/", name="pagamento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pagamentos = $em->getRepository('CamaleaoBimgoCoreBundle:Pagamento')->findAll();

        return $this->render('CamaleaoWebBimgoBundle:pagamento:index.html.twig', array(
            'pagamentos' => $pagamentos,
        ));
    }

    /**
     * Creates a new Pagamento entity.
     *
     * @Route("/new", name="pagamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pagamento = new Pagamento();
        $form = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\PagamentoType', $pagamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pagamento);
            $em->flush();

            return $this->redirectToRoute('pagamento_show', array('id' => $pagamento->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:pagamento:new.html.twig', array(
            'pagamento' => $pagamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pagamento entity.
     *
     * @Route("/{id}", name="pagamento_show")
     * @Method("GET")
     */
    public function showAction(Pagamento $pagamento)
    {
        $deleteForm = $this->createDeleteForm($pagamento);

        return $this->render('CamaleaoWebBimgoBundle:pagamento:show.html.twig', array(
            'pagamento' => $pagamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pagamento entity.
     *
     * @Route("/{id}/edit", name="pagamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pagamento $pagamento)
    {
        $deleteForm = $this->createDeleteForm($pagamento);
        $editForm = $this->createForm('Camaleao\Bimgo\CoreBundle\Form\PagamentoType', $pagamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pagamento);
            $em->flush();

            return $this->redirectToRoute('pagamento_edit', array('id' => $pagamento->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:pagamento:edit.html.twig', array(
            'pagamento' => $pagamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pagamento entity.
     *
     * @Route("/{id}", name="pagamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pagamento $pagamento)
    {
        $form = $this->createDeleteForm($pagamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pagamento);
            $em->flush();
        }

        return $this->redirectToRoute('pagamento_index');
    }

    /**
     * Creates a form to delete a Pagamento entity.
     *
     * @param Pagamento $pagamento The Pagamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pagamento $pagamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pagamento_delete', array('id' => $pagamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
