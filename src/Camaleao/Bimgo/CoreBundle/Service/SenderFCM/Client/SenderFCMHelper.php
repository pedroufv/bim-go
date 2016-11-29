<?php

namespace Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Client;

/**
 * Class SenderFCMHelper
 *
 * @package Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Client
 */
class SenderFCMHelper
{
    /**
     * Todos os usuários
     */
    const TIPO_DESTINATARIO_USUARIO = 1;

    /**
     * Todos os clientes da cidade da empresa
     */
    const TIPO_DESTINATARIO_CLIENTES = 2;

    /**
     * Todos os seguidores
     */
    const TIPO_DESTINATARIO_SEGUIDORES = 3;

    /**
     * Todas as instituições
     */
    const TIPO_DESTINATARIO_INSTITUICOES = 4;

    /**
     * Todos os grupos
     */
    const TIPO_DESTINATARIO_GRUPOS = 5;

    /**
     * Todas as empresas
     */
    const TIPO_DESTINATARIO_EMPRESAS = 6;

    /**
     * Empresas associadas
     */
    const TIPO_DESTINATARIO_EMPRESAS_ASSOCIADAS = 7;

    /**
     * Empresas não associadas
     */
    const TIPO_DESTINATARIO_EMPRESAS_NAO_ASSOCIADAS = 8;

    /**
     * Todos os membros
     */
    const TIPO_DESTINATARIO_MEMBROS = 9;

    /**
     * @param $em
     * @param $empresa
     * @param $destinatarioTipo
     *
     * @return array
     * TODO:remover remetente para TIPO_DESTINATARIO_USUARIO e TIPO_DESTINATARIO_MEMBROS
     */
    public static function mountRecipientList($em, $empresa, $destinatarioTipo, $remetente = null)
    {
        $repository = $em->getRepository('CamaleaoBimgoCoreBundle:Usuario');

        $results = array();
        if ($destinatarioTipo == self::TIPO_DESTINATARIO_USUARIO)
            $results = $repository->findByNotNullRegistrationid();

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_SEGUIDORES)
            $results = $repository->findSeguidoresByNotNullRegistrationid($empresa);

        if ($destinatarioTipo == self::TIPO_DESTINATARIO_CLIENTES)
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

        return $registrationIds;
    }
}