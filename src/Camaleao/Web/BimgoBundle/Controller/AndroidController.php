<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Estado;
use Camaleao\Web\BimgoBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Camaleao\Web\BimgoBundle\Entity\Empresa;

/**
 * Android controller.
 *
 * @Route("/android")
 */
class AndroidController extends Controller
{
    /**
     *  select em usuarios
     *
     * @Route("/checktoken", name="android_checktoken")
     * @Method({"GET", "POST"})
     */
    public function checkTokenAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $token = $jsonObject->object;

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('CamaleaoWebBimgoBundle:Usuario')->findOneBy(array('token' => $token));

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuario, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em estados
     *
     * @Route("/getestados", name="android_getestados")
     * @Method({"GET", "POST"})
     */
    public function getEstadosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $estados = $em->getRepository('CamaleaoWebBimgoBundle:Estado')->findAll();

        $array = array('estados' => $estados);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em notificacoes
     *
     * @Route("/getnotificacoeslazy", name="android_getnotificacoeslazy")
     * @Method({"GET", "POST"})
     */
    public function getNotificacoesLazyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $notificacoes = $em->getRepository('CamaleaoWebBimgoBundle:Notificacao')->findAll();

        $array = array('notificacoes' => $notificacoes);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
     /**
     *  select em segmentos
     *
     * @Route("/getsegmentos", name="android_getsegmentos")
     * @Method({"GET", "POST"})
     */
    public function getSegmentossAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $segmentos = $em->getRepository('CamaleaoWebBimgoBundle:Segmento')->findAll();

        $array = array('segmentos' => $segmentos);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em funcionarios
     *
     * @Route("/getfuncionarios", name="android_getfuncionarios")
     * @Method({"GET", "POST"})
     */
    public function getFuncionariosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $funcionarios = $em->getRepository('CamaleaoWebBimgoBundle:Funcionario')->findAll();

        $array = array('funcionarios' => $funcionarios);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em funcionarios por faixa
     *
     * @Route("/getfuncionarioslazy", name="android_getfuncionarioslazy")
     * @Method({"GET", "POST"})
     */
    public function getFuncionariosLazyAction(Request $request)
    {
	$jsonObject = json_decode($request->get('jsonObject'));

        $index_inicial = $jsonObject->object->index_inicial;
        $quantidade = $jsonObject->object->quantidade;

        $em = $this->getDoctrine()->getManager();

        $funcionarios = $em->getRepository('CamaleaoWebBimgoBundle:Funcionario')
		->findBy(array(), array(), $quantidade, $index_inicial);

        $array = array('funcionarios' => $funcionarios);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em promocoes
     *
     * @Route("/getpromocoes", name="android_getpromocoes")
     * @Method({"GET", "POST"})
     */
    public function getPromocoesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $promocoes = $em->getRepository('CamaleaoWebBimgoBundle:Promocao')->findAll();

        $array = array('promocoes' => $promocoes);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em promocoes por faixa
     *
     * @Route("/getpromocoeslazy", name="android_getpromocoeslazy")
     * @Method({"GET", "POST"})
     */
    public function getPromocoesLazyAction(Request $request)
    {
	$jsonObject = json_decode($request->get('jsonObject'));

        $index_inicial = $jsonObject->object->index_inicial;
        $quantidade = $jsonObject->object->quantidade;

        $em = $this->getDoctrine()->getManager();

        $promocoes = $em->getRepository('CamaleaoWebBimgoBundle:Promocao')
		->findBy(array(), array(), $quantidade, $index_inicial);

        $array = array('promocoes' => $promocoes);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em produtos
     *
     * @Route("/getprodutos", name="android_getprodutos")
     * @Method({"GET", "POST"})
     */
    public function getProdutosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $produtos = $em->getRepository('CamaleaoWebBimgoBundle:Produto')->findAll();

        $array = array('produtos' => $produtos);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em produtos por faixa
     *
     * @Route("/getprodutoslazy", name="android_getprodutoslazy")
     * @Method({"GET", "POST"})
     */
    public function getProdutosLazyAction(Request $request)
    {
	$jsonObject = json_decode($request->get('jsonObject'));

        $index_inicial = $jsonObject->object->index_inicial;
        $quantidade = $jsonObject->object->quantidade;

        $em = $this->getDoctrine()->getManager();

        $produtos = $em->getRepository('CamaleaoWebBimgoBundle:Produto')
		->findBy(array(), array(), $quantidade, $index_inicial);

        $array = array('produtos' => $produtos);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em produtos filtrando
     *
     * @Route("/getprodutosfilter", name="android_getprodutosfilter")
     * @Method("POST")
     */
    public function getProdutosFilterAction(Request $request)
    {
	/*
	$criteria = new \Doctrine\Common\Collections\Criteria();
	$criteria
	  ->orWhere($criteria->expr()->contains('domains', 'a'))
	  ->orWhere($criteria->expr()->contains('domains', 'b'));

	$groups = $em
	  ->getRepository('Group')
	  ->matching($criteria);
	*/

	$jsonObject = json_decode($request->get('jsonObject'));

	$filtros = array();
	$filtros = $jsonObject->object->filtros;
	
	$filter = array();
	foreach($filtros as $registro) {
		$filter[$registro->campo] = $registro->valor;
	}
	
        $em = $this->getDoctrine()->getManager();

        $produtos = $em->getRepository('CamaleaoWebBimgoBundle:Produto')
                ->findBy($filter);

        $array = array('produtos' => $produtos);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em empresas
     *
     * @Route("/getempresas", name="android_getempresas")
     * @Method({"GET", "POST"})
     */
    public function getEmpresasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('CamaleaoWebBimgoBundle:Empresa')->findAll();

        $array = array('empresas' => $empresas);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em empresas por faixa
     *
     * @Route("/getempresaslazy", name="android_getempresaslazy")
     * @Method({"GET", "POST"})
     */
    public function getEmpresasLazyAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $index_inicial = $jsonObject->object->index_inicial;
        $quantidade = $jsonObject->object->quantidade;
	
        $em = $this->getDoctrine()->getManager();

        $empresas = $em->getRepository('CamaleaoWebBimgoBundle:Empresa')
		->findBy(array(), array(), $quantidade, $index_inicial);

        $array = array('empresas' => $empresas);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * insert em usuario
     *
     * @Route("/newusuario", name="android_newusuario")
     * @Method("POST")
     */
    public function newUsuarioAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $usuario = new Usuario();
        $usuario->setNome($jsonObject->object->nome);
        $usuario->setEmail($jsonObject->object->email);
        $usuario->setSenha($jsonObject->object->senha);
        $usuario->setAtivo($jsonObject->object->ativo);

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return new Response(json_encode(array('result' => $usuario->getId())), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * send push message
     *
     * @Route("/sendpushmessage", name="android_sendpushmessage")
     * @Method("POST")
     */
    public function sendPushMessageAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $title = $jsonObject->object->title;
        $message = $jsonObject->object->message;

        //$pushMessage = new PushMessage($title, $message);

        //AplUser::sendPushMessage( $pushMessage );

        $client = $this->get('endroid.gcm.client');

        $registrationIds = array();
        $registrationIds[0] = 'cZ4BeUYgkcA:APA91bG2FYtvI0oorbVwOBJtwndgT7itoYI2LKzDebFYUJg3kdSM_xqd28PVDBKMuUwXkJjKAG2wcyU9QL4aVPi9LHJmyGsopsYI1PQVY8zS7CHrSG2Ir2mLmG50zhVPzcydDo-b2Oer';

        $data = array(
            'title' => $title,
            'message' => $message,
        );


        $options = [
            'collapse_key'=>'PushMessage',
            'delay_while_idle'=>false,
            'time_to_live'=>(4 * 7 * 24 * 60 * 60),
            'restricted_package_name'=>'com.opportunity.minhaempresa',
            'dry_run'=>false
        ];

        $response = $client->send( $data, $registrationIds, $options );

        return new Response(json_encode(array('result' => true)), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * insert em estado
     *
     * @Route("/newestado", name="android_newestado")
     * @Method("POST")
     */
    public function newEstadoAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $estado = new Estado();
        $estado->setNome($jsonObject->object->nome);
        $estado->setUf($jsonObject->object->uf);

        $em = $this->getDoctrine()->getManager();
        $em->persist($estado);
        $em->flush();

        return new Response(json_encode(array('result' => $estado->getId())), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * dispara o insert
     *
     * @Route("/gatilhos", name="android_gatilhos")
     * @Method({"GET", "POST"})
     */
    public function gatilhosAction()
    {
        return $this->render('CamaleaoWebBimgoBundle:android:index.html.twig');
    }
}
