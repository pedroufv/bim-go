<?php

namespace Camaleao\Web\BimgoBundle\Controller;

use Camaleao\Web\BimgoBundle\Entity\Estado;
use Camaleao\Web\BimgoBundle\Entity\Usuario;
use Camaleao\Web\BimgoBundle\Entity\Instituicao;
use Camaleao\Web\BimgoBundle\Entity\Endereco;
use Camaleao\Web\BimgoBundle\Entity\Notificacao;
use Camaleao\Web\BimgoBundle\Entity\Mensagemtipo;
use Camaleao\Web\BimgoBundle\Entity\Destinatariotipo;
use Camaleao\Web\BimgoBundle\Entity\UsuarioInstituicaoPapel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Android controller.
 *
 * @Route("/android")
 */
class AndroidController extends Controller
{
	/**
     * teste upload de imagens
     *
     * @Route("/uplimagens", name="android_uplimagens")
     * @Method("POST")
     */
    public function uplImagensAction(Request $request)
    {
		$mypicture = $request->get('mypicture');

		$array = array('mypicture' => $mypicture);

		return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));

    }


	/**
     * verifica versão app
     *
     * @Route("/chkAppUpdates", name="android_chkAppUpdates")
     * @Method("POST")
     */
    public function chkAppUpdatesAction(Request $request)
    {

		$jsonObject = json_decode($request->get('jsonObject'));

		$versaoInstalada = $jsonObject->object;

		$versaoAtual = 2;
		$urlAtualizacao = "www.google.com.br";

		$resultado = true;

		if ($versaoAtual > $versaoInstalada)
			$resultado = false;

		$array = array('resultado' => $resultado, 'url' => $urlAtualizacao);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

	/**
     * select em usuario instituicao papel
     *
     * @Route("/getusuarioseguir", name="android_getusuarioseguir")
     * @Method("POST")
     */
    public function getUsuarioSeguirAction(Request $request)
    {

		$jsonObject = json_decode($request->get('jsonObject'));

		$filtros = array();
		$filtros = $jsonObject->object->filtros;

		$filter = array();
		foreach($filtros as $registro) {
				$filter[$registro->campo] = $registro->valor;
			}

		$filter['seguindo'] = '1';

		$em = $this->getDoctrine()->getManager();

		$usuarioInstituicaoPapel = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
			->findBy($filter);

		$empresas = array();
        foreach ($usuarioInstituicaoPapel as $registro)
            array_push($empresas, $registro->getInstituicao()->getId());
        
        $array = array('empresas' => $empresas);


            
        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     * set seguindo false em usuario instituicao papel
     *
     * @Route("/remusuarioseguir", name="android_remusuarioseguir")
     * @Method("POST")
     */
    public function remUsuarioSeguirAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));
		
		$resultado = false;

		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$filter = array();
		foreach($filtros as $registro) {
			$filter[$registro->campo] = $registro->valor;
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$usuarioInstituicaoPapel = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
			->findOneBy($filter);
		
		$usuarioInstituicaoPapel->setSeguindo(0);
		
		if ($usuarioInstituicaoPapel) {
			$em->merge($usuarioInstituicaoPapel);
			$em->flush();
			
			$resultado = true;
		}

        $array = array('resultado' => $resultado);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     * new em usuario instituicao papel seguindo true papel 1
     *
     * @Route("/newusuarioseguir", name="android_newusuarioseguir")
     * @Method("POST")
     */
    public function newUsuarioSeguirAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$resultado = false;

		$filtros = array();
		$filtros = $jsonObject->object->filtros;		
		
		$filter = array();
		foreach($filtros as $registro) {
			$filter[$registro->campo] = $registro->valor;
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$usuarioInstituicaoPapel = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
			->findOneBy($filter);
		
		if ($usuarioInstituicaoPapel) {
			$usuarioInstituicaoPapel->setSeguindo(1);
			
			$em->merge($usuarioInstituicaoPapel);
			$em->flush();
			
			$resultado = true;
		} else {
			$usuarioInstituicaoPapel = new UsuarioInstituicaoPapel();
			$usuarioInstituicaoPapel->setUsuario($em->getReference('CamaleaoWebBimgoBundle:Usuario', $filter['usuario']));
			$usuarioInstituicaoPapel->setInstituicao($em->getReference('CamaleaoWebBimgoBundle:Instituicao', $filter['instituicao']));
			$usuarioInstituicaoPapel->setPapel($em->getReference('CamaleaoWebBimgoBundle:Papel', 1));
			$usuarioInstituicaoPapel->setSeguindo(1);			

			$em->persist($usuarioInstituicaoPapel);
			$em->flush();
			
			$resultado = true;
		}

        $array = array('resultado' => $resultado);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     *  select em usuarios
     *
     * @Route("/checklogin", name="android_checklogin")
     * @Method("POST")
     */
    public function checkLoginAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $email = $jsonObject->object->email;
		$senha = md5($jsonObject->object->senha);

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('CamaleaoWebBimgoBundle:Usuario')
			->findOneBy(array('email' => $email, 'senha' => $senha));

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuario, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
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

        $usuario = $em->getRepository('CamaleaoWebBimgoBundle:Usuario')
			->findOneBy(array('token' => $token));

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuario, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     *  update em usuarioinstituicaopapel
     *
     * @Route("/uptusuarioinstituicaopapel", name="android_uptusuarioinstituicaopapel")
     * @Method("POST")
     */
    public function uptUsuarioInstituicaoPapelAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));
		
		$idUsuario = $jsonObject->object->usuario->id;
		$idInstituicao = $jsonObject->object->instituicao->id;
		$idPapel = $jsonObject->object->papel->id;

		$filter = array();
		$filter['usuario'] = $idUsuario;
		$filter['instituicao'] = $idInstituicao;

		$resultado = false;

			$em = $this->getDoctrine()->getManager();

			$usuarioInstituicaoPapel = $em->getPartialReference('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel', $filter);

		if ($usuarioInstituicaoPapel) {
			$usuarioInstituicaoPapel->setPapel($em->getReference('CamaleaoWebBimgoBundle:Papel', $idPapel));

			$em->merge($usuarioInstituicaoPapel);
			$em->flush();

			$resultado = true;
		}

        $array = array('resultado' => $resultado);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

	/**
     *  remove em usuarioinstituicaopapel
     *
     * @Route("/remusuarioinstituicaopapel", name="android_remusuarioinstituicaopapel")
     * @Method("POST")
     */
    public function remUsuarioInstituicaoPapelAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));
		
		$idUsuario = $jsonObject->object->usuario->id;
		$idInstituicao = $jsonObject->object->instituicao->id;
		//$idPapel = $jsonObject->object->papel->id;

		$filter = array();
		$filter['usuario'] = $idUsuario;
		$filter['instituicao'] = $idInstituicao;

		$resultado = false;

        $em = $this->getDoctrine()->getManager();

        $usuarioInstituicaoPapel = $em->getPartialReference('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel', $filter);

		if ($usuarioInstituicaoPapel) {
			$em->remove($usuarioInstituicaoPapel);
			$em->flush();

			$resultado = true;
		}

        $array = array('resultado' => $resultado);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

	/**
     *  update em usuarios
     *
     * @Route("/uptusuario", name="android_uptusuario")
     * @Method("POST")
     */
    public function uptUsuarioAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));
		
		$id = $jsonObject->object->id;
		$registrationid = $jsonObject->object->registrationid;
		
		$resultado = false;

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getReference('CamaleaoWebBimgoBundle:Usuario', $id);
		if ($usuario) {
			$usuario->setRegistrationid($registrationid);
			$em->merge($usuario);
			$em->flush();
			
			$resultado = true;
		}

        $array = array('resultado' => $resultado);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

	/**
     *  update em usuarios
     *
     * @Route("/uptsenhausuario", name="android_uptsenhausuario")
     * @Method("POST")
     */
    public function uptSenhaUsuarioAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));
		
		$id = $jsonObject->object->id;
		$senha = $jsonObject->object->senha;

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getReference('CamaleaoWebBimgoBundle:Usuario', $id);
		if ($usuario) {
			$usuario->setSenha($senha);
			$chave = $jsonObject->object->email . $senha;
			$usuario->setToken($chave);
			$em->merge($usuario);
			$em->flush();
		}

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuario, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     *  select em usuarioinstituicaopapel
     *
     * @Route("/checkusuarioinstituicaopapel", name="android_checkusuarioinstituicaopapel")
     * @Method({"GET", "POST"})
     */
    public function checkUsuarioInstituicaoPapelAction(Request $request)
    {
		$resultado = false;
	
        $jsonObject = json_decode($request->get('jsonObject'));

		$id = $jsonObject->object;
		
		$em = $this->getDoctrine()->getManager();

        $usuarioinstituicaopapel = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
			->findUsuarioEhMembroDeAlgumaInstituicao($id);

        if ($usuarioinstituicaopapel)
			$resultado = true;
			
		$array = array('resultado' => $resultado);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  insert em usuarioinstituicaopapel
     *
     * @Route("/newusuarioinstituicaopapel", name="android_newusuarioinstituicaopapel")
     * @Method({"GET", "POST"})
     */
    public function newUsuarioInstituicaoPapelAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$em = $this->getDoctrine()->getManager();

        $usuarioinstituicaopapel = new UsuarioInstituicaoPapel();
        $usuarioinstituicaopapel->setUsuario($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->usuario->id));
        $usuarioinstituicaopapel->setInstituicao($em->getReference('CamaleaoWebBimgoBundle:Instituicao', $jsonObject->object->instituicao->id));
        $usuarioinstituicaopapel->setPapel($em->getReference('CamaleaoWebBimgoBundle:Papel', $jsonObject->object->papel->id));
        
        $em->persist($usuarioinstituicaopapel);
        $em->flush();

		$serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuarioinstituicaopapel, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     *  select em cidades filtrando
     *
     * @Route("/getcidadesfilter", name="android_getcidadesfilter")
     * @Method("POST")
     */
    public function getCidadesFilterAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$filter = array();
		foreach($filtros as $registro) {
			$filter[$registro->campo] = $registro->valor;
		}
		
        $em = $this->getDoctrine()->getManager();

        $cidades = $em->getRepository('CamaleaoWebBimgoBundle:Cidade')
                ->findBy($filter);

        $array = array('cidades' => $cidades);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     *  select em cidades filtrando
     *
     * @Route("/getcidadesparticipantesfilter", name="android_getcidadesparticipantesfilter")
     * @Method("POST")
     */
    public function getCidadesParticipantesFilterAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$filter = array();
		foreach($filtros as $registro) {
			$filter[$registro->campo] = $registro->valor;
		}
		
		$filter['participante'] = '1';
		
        $em = $this->getDoctrine()->getManager();

        $cidades = $em->getRepository('CamaleaoWebBimgoBundle:Cidade')
                ->findBy($filter);

        $array = array('cidades' => $cidades);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

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
     *  select em estados
     *
     * @Route("/getestadosparticipantes", name="android_getestadosparticipantes")
     * @Method({"GET", "POST"})
     */
    public function getEstadosParticipantesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $estados = $em->getRepository('CamaleaoWebBimgoBundle:Cidade')->findByEstadosParticipantes();

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
        $jsonObject = json_decode($request->get('jsonObject'));

        $index_inicial = $jsonObject->object->index_inicial;
        $quantidade = $jsonObject->object->quantidade;
		
		$em = $this->getDoctrine()->getManager();

        $notificacoes = $em->getRepository('CamaleaoWebBimgoBundle:Notificacao')
		->findBy(array(), array(), $quantidade, $index_inicial);

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
	 *  select em produtos
	 *
	 * @Route("/getprodutosbycidade", name="android_getprodutosbycidade")
	 * @Method({"GET", "POST"})
	 */
	public function getProdutosByCidadeAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$produtos = $em->getRepository('CamaleaoWebBimgoBundle:Produto')->findProdutoByCidade(1);

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
     *  select em mensagem tipo
     *
     * @Route("/gettipomensagem", name="android_gettipomensagem")
     * @Method({"GET", "POST"})
     */
    public function getTipoMensagemAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tipomensagem = $em->getRepository('CamaleaoWebBimgoBundle:Mensagemtipo')->findAll();

        $array = array('tipomensagem' => $tipomensagem);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

     /**
     *  select em papel
     *
     * @Route("/getpapeis", name="android_getpapeis")
     * @Method({"GET", "POST"})
     */
    public function getPapeisAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $papeis = $em->getRepository('CamaleaoWebBimgoBundle:Papel')->findAll();

        $array = array('papeis' => $papeis);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     *  select em papel filtrando
     *
     * @Route("/getpapeisfilter", name="android_getpapeisfilter")
     * @Method({"GET", "POST"})
     */
    public function getPapeisFilterAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$filter = array();
		foreach($filtros as $registro) {
			$filter[$registro->campo] = $registro->valor;
		}
		
		$em = $this->getDoctrine()->getManager();
		
        $papeis = $em->getRepository('CamaleaoWebBimgoBundle:Papel')->findBy($filter);

        $array = array('papeis' => $papeis);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

     /**
     *  select em contato tipo
     *
     * @Route("/gettipocontato", name="android_gettipocontato")
     * @Method({"GET", "POST"})
     */
    public function getTipoContatoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $contatotipo = $em->getRepository('CamaleaoWebBimgoBundle:Contatotipo')->findAll();

        $array = array('contatotipo' => $contatotipo);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

     /**
     *  select em destinatario tipo
     *
     * @Route("/gettipodestinatario", name="android_gettipodestinatario")
     * @Method({"GET", "POST"})
     */
    public function getTipoDestinatarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tipodestinatario = $em->getRepository('CamaleaoWebBimgoBundle:Destinatariotipo')->findAll();

        $array = array('tipodestinatario' => $tipodestinatario);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em usuarioinstituicaopapel
     *
     * @Route("/getusuariosmembroporinstituicaolazy", name="android_getusuariosmembroporinstituicaolazy")
     * @Method({"GET", "POST"})
     */
    public function getUsuariosMembroPorInstituicaoLazy(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

		$filtros = array();
		$filtros = $jsonObject->object->filtros;

		$filter = array();
		foreach($filtros as $registro) {
			$filter[$registro->campo] = $registro->valor;
		}

		$index_inicial = $jsonObject->object->intervalo->index_inicial;
			$quantidade = $jsonObject->object->intervalo->quantidade;

		$em = $this->getDoctrine()->getManager();

		$usuarioinstituicaopapel = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
			->findUsuariosMembroPorInstituicaoLazy($filter['instituicao'], $index_inicial, $quantidade);

        $array = array('usuarioinstituicaopapel' => $usuarioinstituicaopapel);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em usuarioinstituicaopapel filter
     *
     * @Route("/getusuarioinstituicaopapelfilter", name="android_getusuarioinstituicaopapelfilter")
     * @Method({"GET", "POST"})
     */
    public function getUsuarioInstituicaoPapelFilterAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

		$filtros = array();
		$filtros = $jsonObject->object->filtros;

		$filter = array();
		foreach($filtros as $registro) {
			$filter[$registro->campo] = $registro->valor;
		}

		$em = $this->getDoctrine()->getManager();

        /*$usuarioinstituicaopapel = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
		->findBy($filter);*/

		$usuarioinstituicaopapel = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
		->findInstituicoesPorUsuarioMembro($filter['usuario']);

        $array = array('usuarioinstituicaopapel' => $usuarioinstituicaopapel);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em instituicoes
     *
     * @Route("/getinstituicoes", name="android_getinstituicoes")
     * @Method({"GET", "POST"})
     */
    public function getInstituicoesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoWebBimgoBundle:Instituicao')->findAll();

        $array = array('instituicoes' => $instituicoes);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

	/**
	 *  select em instituicoes
	 *
	 * @Route("/getinstituicoesbycidade", name="android_getinstituicoesbycidade")
	 * @Method({"GET", "POST"})
	 */
	public function getInstituicoesByCidadeAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$instituicoes = $em->getRepository('CamaleaoWebBimgoBundle:Instituicao')->findInstituicaoByCidade();

		dump($instituicoes); exit;

		$array = array('instituicoes' => $instituicoes);

		$serializer = $this->container->get('jms_serializer');

		$result = $serializer->serialize($array, 'json');

		return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
	}
	
	/**
     *  get instituicoes por segmento
     *
     * @Route("/getinstituicoessegmento", name="android_getinstituicoessegmento")
     * @Method("POST")
     */
    public function getInstituicoesSegmentoAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));
		
		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$id;
		foreach($filtros as $registro) {
			$id = $registro->valor;
		}
		
		$index_inicial = $jsonObject->object->intervalo->index_inicial;
        $quantidade = $jsonObject->object->intervalo->quantidade;
		
		$em = $this->getDoctrine()->getManager();
		
		$instituicoes = $em->getRepository('CamaleaoWebBimgoBundle:Instituicao')->getInstituicaoBySegmento($id, $index_inicial, $quantidade);
		
		$array = array('instituicoes' => $instituicoes);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
	}
	
	/**
     *  filtra em entidades lazy
     *
     * @Route("/getentidadefilterlazy", name="android_getentidadefilterlazy")
     * @Method("POST")
     */
    public function getEntidadeFilterLazyAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));
		
		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$filter = array();
		foreach($filtros as $registro) {
			if ($registro->campo == 'entidade')
				$entidade = $registro->valor;
			else
				$filter[$registro->campo] = $registro->valor;
		}
		
		$index_inicial = $jsonObject->object->intervalo->index_inicial;
        $quantidade = $jsonObject->object->intervalo->quantidade;
	
        $em = $this->getDoctrine()->getManager();

		$entidades = $em->getRepository('CamaleaoWebBimgoBundle:' . $entidade)
                ->findBy($filter, array(), $quantidade, $index_inicial);

        $array = array('entidades' => $entidades);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     *  filtra em entidades
     *
     * @Route("/getentidadesfilter", name="android_getentidadesfilter")
     * @Method("POST")
     */
    public function getEntidadesFilterAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));
		
		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$filter = array();
		foreach($filtros as $registro) {
			if ($registro->campo == 'entidade')
				$entidade = $registro->valor;
			else
				$filter[$registro->campo] = $registro->valor;
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$resultado = false;
		
		$entidades = $em->getRepository('CamaleaoWebBimgoBundle:' . $entidade)
                ->findBy($filter);

        $array = array('entidades' => $entidades);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

     /**
     *  select em entidade
     *
     * @Route("/getentidadefilter", name="android_getentidadefilter")
     * @Method("POST")
     */
    public function getEntidadeFilterAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));
		
		$filtros = array();
		$filtros = $jsonObject->object->filtros;

		$filter = array();
		foreach($filtros as $registro) {
			if ($registro->campo == 'entidade')
				$entidade = $registro->valor;
			else
				$filter[$registro->campo] = $registro->valor;
		}
	
        $em = $this->getDoctrine()->getManager();

		$entidade = $em->getRepository('CamaleaoWebBimgoBundle:' . $entidade)
                ->findOneBy($filter);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($entidade, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  remove em entidades
     *
     * @Route("/rementidade", name="android_rementidade")
     * @Method("POST")
     */
    public function remEntidadeAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));
		
		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$filter = array();
		foreach($filtros as $registro) {
			if ($registro->campo == 'entidade')
				$entidade = $registro->valor;
			else
				$filter[$registro->campo] = $registro->valor;
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$resultado = false;
		
		$instituicao = $em->getPartialReference('CamaleaoWebBimgoBundle:' . $entidade, $filter);
		if ($instituicao) {
			$em->remove($instituicao);
			$em->flush();
			
			$resultado = true;
		}

        $array = array('resultado' => $resultado);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  remove em instituicoes
     *
     * @Route("/reminstituicoes", name="android_reminstituicoes")
     * @Method({"GET", "POST"})
     */
    public function remInstituicaosAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$filtros = array();
		$filtros = $jsonObject->object->filtros;
		
		$filter = array();
		foreach($filtros as $registro) {
			$filter[$registro->campo] = $registro->valor;
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$resultado = false;
		
		$instituicao = $em->getPartialReference('CamaleaoWebBimgoBundle:Instituicao', $filter);
		if ($instituicao) {
			$em->remove($instituicao);
			$em->flush();
			
			$resultado = true;
		}

        $array = array('resultado' => $resultado);

        return new Response(json_encode($array), Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     *  select em instituicoes por faixa
     *
     * @Route("/getinstituicoeslazy", name="android_getinstituicoeslazy")
     * @Method({"GET", "POST"})
     */
    public function getInstituicoesLazyAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $index_inicial = $jsonObject->object->index_inicial;
        $quantidade = $jsonObject->object->quantidade;
	
        $em = $this->getDoctrine()->getManager();

        $instituicoes = $em->getRepository('CamaleaoWebBimgoBundle:Instituicao')
		->findBy(array(), array(), $quantidade, $index_inicial);

        $array = array('instituicoes' => $instituicoes);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

     /**
     * insert em usuario
     *
     * @Route("/getpapel", name="android_getpapel")
     * @Method("GET")
     */
    public function getPapel($filter)
    {
		$em = $this->getDoctrine()->getManager();

		$papel = $em->getRepository('CamaleaoWebBimgoBundle:Papel')
		->findOneBy($filter);

        return $papel;
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
		$chave = $jsonObject->object->email . $jsonObject->object->senha;
		$usuario->setToken($chave);
	
		$em = $this->getDoctrine()->getManager();
	
		$usuario->setPapel($em->getReference('CamaleaoWebBimgoBundle:Papel', 1));
        
        $em->persist($usuario);
        $em->flush();

		$message = \Swift_Message::newInstance()
			->setSubject('Bem vindo ao Bim-go!')
			->setFrom('cpe.feroz@gmail.com')
			->setTo($usuario->getEmail())
			->setBody(
				$this->renderView('CamaleaoWebBimgoBundle:usuario:emailnew.html.twig', array('usuario' => $usuario)),
				"text/html"
			)
		;
		$this->get('mailer')->send($message);

		$serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($usuario, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
    public function getSeguidas($id) {
		$em = $this->getDoctrine()->getManager();
		
		$result = $em->getRepository('CamaleaoWebBimgoBundle:UsuarioInstituicaoPapel')
		->createQueryBuilder('usuarioInstituicaoPapel')
		->select('usuarioInstituicaoPapel.instituicao')
		->where("usuarioInstituicaoPapel.usuario = $id")
		->getQuery()
		->getResult();

		return $result;
    }
	
	/**
     * seguir instituicao
     *
     * @Route("/seguirinstituicao", name="android_seguirinstituicao")
     * @Method("POST")
     */
    public function seguirInstituicaoAction(Request $request)
    {
	
	}
	
	/**
     * get instituicoes seguidas
     *
     * @Route("/getinstituicoesseguidas", name="android_getinstituicoesseguidas")
     * @Method("POST")
     */
    public function getInstituicoesSeguidasAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $idUsuario = $jsonObject->object->usuario;

        $instituicoes = $this->getSeguidas($idUsuario);
		
		$seguidas = array();
		$i = 0;
		foreach($instituicoes as $registro)
			$seguidas[$i++] = $registro['instituicao'];
		
        $array = array('instituicoes' => $seguidas);

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($array, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
    public function getDestinationUsers() {
		$em = $this->getDoctrine()->getManager();
		
		$result = $em->getRepository('CamaleaoWebBimgoBundle:Usuario')
		->createQueryBuilder('usuario')
		->select('usuario.registrationid')
		->where('usuario.registrationid IS NOT NULL')
		->andWhere("usuario.registrationid != ''")
		->distinct('usuario.registrationid')
		->getQuery()
		->getResult();
		
		return $result;
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

		$client = $this->get('endroid.gcm.client');

        $usuarios = $this->getDestinationUsers();
		
		$registrationIds = array();
		foreach ($usuarios as $registro)
			array_push($registrationIds, $registro['registrationid']);
		
        $data = array(
            'title' => $title,
            'message' => $message,
        );

        $options = [
            'collapse_key'=>'PushMessageBim-go',
            'delay_while_idle'=>false,
            'time_to_live'=>(4 * 7 * 24 * 60 * 60),
            'restricted_package_name'=>'br.com.camaleao.bim_go',
            'dry_run'=>false
        ];

        $response = $client->send($data, $registrationIds, $options);

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
     * insert em notificacao
     *
     * @Route("/newnotificacao", name="android_newnotificacao")
     * @Method("POST")
     */
    public function newNotificacaoAction(Request $request)
    {
        $jsonObject = json_decode($request->get('jsonObject'));

        $notificacao = new Notificacao();
		
		$em = $this->getDoctrine()->getManager();
		
        $notificacao->setMensagemtipo($em->getReference('CamaleaoWebBimgoBundle:Mensagemtipo', $jsonObject->object->mensagemtipo->id));
        $notificacao->setDestinatariotipo($em->getReference('CamaleaoWebBimgoBundle:Destinatariotipo', $jsonObject->object->destinatariotipo->id));
        $notificacao->setRemetente($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->remetente->id));
        $notificacao->setInstituicao($em->getReference('CamaleaoWebBimgoBundle:Instituicao', $jsonObject->object->instituicao->id));
        $notificacao->setMensagem($jsonObject->object->mensagem);
		
		$now = new \DateTime();
		$notificacao->setData($now);

        $em->persist($notificacao);
        $em->flush();
		
		$serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($notificacao, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * insert em instituicoes
     *
     * @Route("/newinstituicao", name="android_newinstituicao")
     * @Method("POST")
     */
    public function newInstituicaoAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$jsonData = json_encode($jsonObject->object);

		$serializer = $this->container->get('jms_serializer');

		$instituicao = $serializer->deserialize($jsonData, 'Camaleao\Web\BimgoBundle\Entity\Instituicao', 'json');

		$now = new \DateTime();
		$instituicao->setDatacriado($now);

		$em = $this->getDoctrine()->getManager();
		
        $instituicao->setCriadopor($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->criadopor->id));
		$instituicao->setModificadopor($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->modificadopor->id));

		$em->merge($instituicao->getEndereco());
        $instituicao = $em->merge($instituicao);
        $em->flush();

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($instituicao, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * update em instituicoes
     *
     * @Route("/uptinstituicao", name="android_uptinstituicao")
     * @Method("POST")
     */
    public function uptInstituicaoAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$jsonData = json_encode($jsonObject->object);

		$serializer = $this->container->get('jms_serializer');

		$instituicao = $serializer->deserialize($jsonData, 'Camaleao\Web\BimgoBundle\Entity\Instituicao', 'json');

		$em = $this->getDoctrine()->getManager();

			//$instituicao->setCriadopor($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->criadopor->id));
		//$instituicao->setModificadopor($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->modificadopor->id));

		$em->merge($instituicao->getEndereco());
        $em->merge($instituicao);
        $em->flush();

        $serializer = $this->container->get('jms_serializer');

        $result = $serializer->serialize($instituicao, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     * insert em produtos
     *
     * @Route("/newproduto", name="android_newproduto")
     * @Method("POST")
     */
    public function newProdutoAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$jsonData = json_encode($jsonObject->object);

		$serializer = $this->container->get('jms_serializer');

		$produto = $serializer->deserialize($jsonData, 'Camaleao\Web\BimgoBundle\Entity\Produto', 'json');

		$now = new \DateTime();
		$produto->setDatacriado($now);

		$em = $this->getDoctrine()->getManager();

		/*$produto->setInstituicao($em->getReference('CamaleaoWebBimgoBundle:Instituicao', $jsonObject->object->instituicao->id));
		$produto->setCriadopor($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->criadopor->id));
		$produto->setModificadopor($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->modificadopor->id));*/

        $produto = $em->merge($produto);
        $em->flush();

        $result = $serializer->serialize($produto, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

	/**
     * update em produtos
     *
     * @Route("/uptproduto", name="android_uptproduto")
     * @Method("POST")
     */
    public function uptProdutoAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$jsonData = json_encode($jsonObject->object);

		$serializer = $this->container->get('jms_serializer');

		$produto = $serializer->deserialize($jsonData, 'Camaleao\Web\BimgoBundle\Entity\Produto', 'json');

		$em = $this->getDoctrine()->getManager();
	
        $em->merge($produto);
        $em->flush();

        $result = $serializer->serialize($produto, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
	
	/**
     * insert em funcionarios
     *
     * @Route("/newfuncionario", name="android_newfuncionario")
     * @Method("POST")
     */
    public function newFuncionarioAction(Request $request)
    {
		$jsonObject = json_decode($request->get('jsonObject'));

		$jsonData = json_encode($jsonObject->object);

		$serializer = $this->container->get('jms_serializer');

		$funcionario = $serializer->deserialize($jsonData, 'Camaleao\Web\BimgoBundle\Entity\Funcionario', 'json');

		$now = new \DateTime();
		$funcionario->setDatacriacao($now);

		$em = $this->getDoctrine()->getManager();

		//$funcionario->setCriadopor($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->criadopor->id));
		//$funcionario->setModificadopor($em->getReference('CamaleaoWebBimgoBundle:Usuario', $jsonObject->object->modificadopor->id));
		$funcionario->getEndereco()->setCidade($em->getReference('CamaleaoWebBimgoBundle:Cidade', $jsonObject->object->endereco->cidade->id));

		$em->persist($funcionario->getEndereco());
        $funcionario = $em->merge($funcionario);
        $em->flush();

        $result = $serializer->serialize($funcionario, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

	/**
     * update em funcionarios
     *
     * @Route("/uptfuncionario", name="android_uptfuncionario")
     * @Method("POST")
     */
    public function uptFuncionarioAction(Request $request)
    {	
		$jsonObject = json_decode($request->get('jsonObject'));

		$jsonData = json_encode($jsonObject->object);

		$serializer = $this->container->get('jms_serializer');

		$funcionario = $serializer->deserialize($jsonData, 'Camaleao\Web\BimgoBundle\Entity\Funcionario', 'json');

		$em = $this->getDoctrine()->getManager();

        $em->merge($funcionario->getEndereco());
        $em->merge($funcionario);
        $em->flush();

        $result = $serializer->serialize($funcionario, 'json');

        return new Response($result, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    /**
     * s3
     *
     * @Route("/s3", name="android_s3")
     * @Method("GET")
     */
    public function s3Action(Request $request)
    {
        $s3 = $this->get('aws.s3');


        $pathToFile = 'bundles/camaleaowebbimgo/img/favicon.ico';

        //'Key'    => $_FILES['file']['name'],
        //'SourceFile' => $_FILES['file']['tmp_name'],

        $response = $s3->putObject(array(
            'Bucket' => 'camaleao',
            'Key'    => 'bim-go/favicon.ico',
            'Body'   => fopen($pathToFile, 'r+')
        ));

        $result = array('result' => false);
        if($response) {
            $result = array('result' => true);
        }

        return new JsonResponse(json_encode($result));
    }

	/**
	 * teste envio de email
	 *
	 * @Route("/testeenvioemail", name="android_testeenvioemail")
	 * @Method("GET")
	 */
	public function testeEnvioEmailAction()
	{
		$em = $this->getDoctrine()->getManager();

		$usuario = $em->getRepository('CamaleaoWebBimgoBundle:Usuario')
			->findOneBy(array('email' => 'pams.pedro@gmail.com'));

		$message = \Swift_Message::newInstance()
			->setSubject('Bem vindo ao Bim-go!')
			->setFrom('cpe.feroz@gmail.com')
			->setTo($usuario->getEmail())
			->setBody(
				$this->renderView('CamaleaoWebBimgoBundle:usuario:emailnew.html.twig', array('usuario' => $usuario)),
				"text/html"
			)
		;
		$this->get('mailer')->send($message);

		return $this->render('CamaleaoWebBimgoBundle:usuario:emailnew.html.twig', array('usuario' => $usuario));
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
