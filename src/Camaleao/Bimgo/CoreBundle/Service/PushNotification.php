<?php

namespace Camaleao\Bimgo\CoreBundle\Service;

use Camaleao\Bimgo\CoreBundle\Entity\Destinatariotipo;
use Doctrine\ORM\EntityManager;
use Endroid\Gcm\Client;

/**
 * PushMessage service.
 */
class PushNotification
{
    /**
     * Todos os usuários
     */
    const TIPO_DESTINATARIO_USUARIO = 1;

    /**
     * Todos os seguidores
     */
    const TIPO_DESTINATARIO_SEGUIDORES = 2;

    /**
     * Todas as instituições
     */
    const TIPO_DESTINATARIO_INSTITUICOES = 3;

    /**
     * Todos os grupos
     */
    const TIPO_DESTINATARIO_GRUPOS = 4;

    /**
     * Todas as empresas
     */
    const TIPO_DESTINATARIO_EMPRESAS = 5;

    /**
     * Empresas associadas
     */
    const TIPO_DESTINATARIO_EMPRESAS_ASSOCIADAS = 6;

    /**
     * Empresas não associadas
     */
    const TIPO_DESTINATARIO_EMPRESAS_NAO_ASSOCIADAS = 7;

    /**
     * Todos os membros
     */
    const TIPO_DESTINATARIO_MEMBROS = 8;


    /**
     * @var Client
     */
    protected $client;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $registrationIds = array();

    /**
     * @var array
     */
    protected $options = array(
        'collapse_key'=>'PushMessageBim-go',
        'delay_while_idle'=>false,
        'time_to_live'=>2419200,
        'restricted_package_name'=>'br.com.camaleao.bim_go',
        'dry_run'=>false
    );


    /**
     * @param Client $client
     * @param EntityManager $em
     */
    public function __construct(Client $client, EntityManager $em)
    {
        $this->client = $client;
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getRegistrationIds()
    {
        return $this->registrationIds;
    }

    /**
     * @param array $registrationIds
     */
    public function setRegistrationIds($registrationIds)
    {
        $this->registrationIds = $registrationIds;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param $empresa
     * @param $destinatarioTipo
     * @return array
     * TODO:remover remetente para TIPO_DESTINATARIO_USUARIO e TIPO_DESTINATARIO_MEMBROS
     */
    public function mountRecipientList($empresa, $destinatarioTipo)
    {
        $repository = $this->em->getRepository('CamaleaoBimgoCoreBundle:Usuario');

        $results = array();
        if ($destinatarioTipo == self::TIPO_DESTINATARIO_USUARIO)
            $results = $repository->findByNotNullRegistrationid();

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_SEGUIDORES)
            $results = $repository->findSeguidoresByNotNullRegistrationid($empresa);

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_INSTITUICOES)
            $results = $repository->findManagerByNotNullRegistrationid();

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_GRUPOS)
            $results = $repository->findGroupByNotNullRegistrationid();

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_EMPRESAS)
            $results = $repository->findEmpresaByNotNullRegistrationid();

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_EMPRESAS_ASSOCIADAS)
            $results = $repository->findEmpresaAssociadaByNotNullRegistrationid($empresa);

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_EMPRESAS_NAO_ASSOCIADAS)
            $results = $repository->findEmpresaNaoAssociadaByNotNullRegistrationid($empresa);

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_MEMBROS)
            $results = $repository->findMembersByNotNullRegistrationid($empresa);

        $registrationIds = array();
        foreach ($results as $result)
            array_push($registrationIds, $result['registrationid']);

        $this->registrationIds = $registrationIds;
    }

    /**
     * send Notificacao
     */
    public function send()
    {
        if(empty($this->data) OR empty($this->registrationIds) OR empty($this->options))
            return false;

        return $this->client->send($this->data, $this->registrationIds, $this->options);
    }
}