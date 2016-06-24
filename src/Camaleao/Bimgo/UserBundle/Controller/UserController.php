<?php

namespace Camaleao\Bimgo\UserBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Usuario controller.
 */
class UserController extends Controller
{
    /**
     * @Route("/entrar", name="user_usuario_entrar")
     * @Method({"GET", "POST"})
     */
    public function entrarAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
        }

        return $this->render('CamaleaoBimgoUserBundle:usuario:entrar.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * @Route("/redirecionar", name="user_usuario_redirecionar")
     * @Method("GET")
     */
    public function redirecionarAction(Request $request)
    {
        $session = $request->getSession();

        $roles = $this->get('security.token_storage')->getToken()->getRoles();

        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);

        if(in_array('ROLE_ADMINISTRADOR', $rolesTab))
            return $this->redirectToRoute('admin_inicial_index');

        if(in_array('ROLE_MEMBRO', $rolesTab))
            return $this->redirectToRoute('site_inicial_index');

        if(in_array('ROLE_CLIENTE', $rolesTab))
            return $this->redirectToRoute('customer_inicial_index');
    }

    /**
     * Active Usuario entity by token
     *
     * @Route("/ativar/{token}", name="android_ativarusuario")
     * @Method("GET")
     */
    public function ativarAction(Request $request)
    {
        $token = $request->get('token');

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('CamaleaoBimgoCoreBundle:Usuario')->findOneBy(array('token' => $token));

        $usuario->setAtivo(1);
        $em->persist($usuario);
        $em->flush();

        return $this->render('CamaleaoBimgoUserBundle:usuario:actived.html.twig');
    }

    /**
     * @Route("/autenticar", name="user_usuario_autenticar")
     * @Method("POST")
     */
    public function autenticarAction() { }

    /**
     * @Route("/sair", name="user_usuario_sair")
     * @Method("GET")
     */
    public function sairAction() { }
}
