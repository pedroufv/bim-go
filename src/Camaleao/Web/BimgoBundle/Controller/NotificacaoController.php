<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Notificacao;
use Camaleao\Web\BimgoBundle\Form\NotificacaoType;

/**
 * Notificacao controller.
 *
 * @Route("/notificacao")
 */
class NotificacaoController extends Controller
{
    /**
     * Lists all Notificacao entities.
     *
     * @Route("/", name="notificacao_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notificacaos = $em->getRepository('CamaleaoWebBimgoBundle:Notificacao')->findAll();

        return $this->render('CamaleaoWebBimgoBundle:notificacao:index.html.twig', array(
            'notificacaos' => $notificacaos,
        ));
    }

    /**
     * Creates a new Notificacao entity.
     *
     * @Route("/new", name="notificacao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $notificacao = new Notificacao();
        $form = $this->createForm('Camaleao\Web\BimgoBundle\Form\NotificacaoType', $notificacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notificacao);
            $em->flush();

            return $this->redirectToRoute('notificacao_show', array('id' => $notificacao->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:notificacao:new.html.twig', array(
            'notificacao' => $notificacao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Notificacao entity.
     *
     * @Route("/{id}", name="notificacao_show")
     * @Method("GET")
     */
    public function showAction(Notificacao $notificacao)
    {
        $deleteForm = $this->createDeleteForm($notificacao);

        return $this->render('CamaleaoWebBimgoBundle:notificacao:show.html.twig', array(
            'notificacao' => $notificacao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Notificacao entity.
     *
     * @Route("/{id}/edit", name="notificacao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Notificacao $notificacao)
    {
        $deleteForm = $this->createDeleteForm($notificacao);
        $editForm = $this->createForm('Camaleao\Web\BimgoBundle\Form\NotificacaoType', $notificacao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notificacao);
            $em->flush();

            return $this->redirectToRoute('notificacao_edit', array('id' => $notificacao->getId()));
        }

        return $this->render('CamaleaoWebBimgoBundle:notificacao:edit.html.twig', array(
            'notificacao' => $notificacao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Notificacao entity.
     *
     * @Route("/{id}", name="notificacao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Notificacao $notificacao)
    {
        $form = $this->createDeleteForm($notificacao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notificacao);
            $em->flush();
        }

        return $this->redirectToRoute('notificacao_index');
    }

    /**
     * Creates a form to delete a Notificacao entity.
     *
     * @param Notificacao $notificacao The Notificacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notificacao $notificacao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notificacao_delete', array('id' => $notificacao->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
