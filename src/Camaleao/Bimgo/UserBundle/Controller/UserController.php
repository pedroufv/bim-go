<?php

namespace Camaleao\Bimgo\UserBundle\Controller;

use Camaleao\Bimgo\CoreBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
