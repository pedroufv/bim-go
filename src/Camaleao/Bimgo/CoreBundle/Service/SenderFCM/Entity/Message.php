<?php

namespace Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Entity;

use Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Model\FCM;

/**
 * Class Message
 * 
 * Representa a mensagem que será enviada, codificada em json, aos servidores do FCM
 * 
 * @package Camaleao\Animallovers\ApiBundle\Services\SenderFCM\Entity
 */
class Message
{
    /* Destinos */

    /**
     * Este parâmetro especifica o destinatário de uma mensagem.
     *
     * O valor deve ser um token de registro, uma chave de notificação ou um tópico.
     * Não defina esse campo ao enviar vários tópicos.
     * Consulte condition.
     *
     * @var string $to
     */
    private $to;

    /**
     * Nome do tópico a ser enviado no $to.
     *
     * @var string $topic
     */
    private $topic;

    /**
     * Este parâmetro especifica uma lista de dispositivos (tokens de registro, ou IDs) que recebem uma mensagem multicast.
     * Ele deve conter entre 1 e 1.000 tokens de registro.
     *
     * Use esse parâmetro apenas para mensagens multicast e não para destinatários únicos.
     * Mensagens multicast (envio para mais de um token de registro) são permitidas somente no formato JSON HTTP.
     *
     * @var array $registration_ids
     */
    private $registration_ids;

    /**
     * Este parâmetro especifica uma expressão lógica de condições que determinam o destino da mensagem.
     *
     * Condição disponível: tópico, formatado como "'seu tópico' in topics".
     * Esse valor não diferencia minúsculas de maiúsculas.
     *
     * Operadores disponíveis: &&, ||. São permitidos no máximo de dois operadores por mensagem de tópico.
     *
     * @var string $condition
     */
    private $condition;

    /* Opções */

    /**
     * Este parâmetro identifica um grupo de mensagens (por exemplo, com collapse_key: "Updates Available")
     * que podem ser recolhidas para que apenas a última mensagem seja enviada quando for possível retomar a entrega.
     * Isso tem como objetivo evitar o envio de um número excessivo de mensagens iguais
     * quando o dispositivo fica on-line ou ativo novamente (consulte delay_while_idle).
     *
     * Observe que não há garantia acerca da ordem em que as mensagens são enviadas.
     *
     * Observação: São permitidas no máximo 4 chaves de recolhimento diferentes a qualquer momento.
     * Isso significa que um servidor de conexão do FCM pode armazenar simultaneamente 4 mensagens de envio para
     * sincronização diferentes por aplicativo cliente. Se você ultrapassar esse número,
     * não há garantia de quais 4 chaves de recolhimento serão mantidas pelo servidor de conexão do FCM.
     *
     * @var string $collapse_key
     */
    private $collapse_key;

    /**
     * Define a prioridade da mensagem. Os valores válidos são "normal" e "high". No iOS, correspondem
     * às prioridades 5 e 10 dos APNs.
     *
     * Por padrão, mensagens são enviadas com a prioridade normal. A prioridade normal otimiza o consumo de bateria
     * do aplicativo cliente e deve ser sempre usada, exceto quando a entrega imediata é necessária.
     * Para mensagens com prioridade normal, o aplicativo pode receber a mensagem com atraso não especificado.
     *
     * Quando uma mensagem é enviada com alta prioridade, ela é enviada imediatamente e o aplicativo pode acionar
     * um dispositivo em suspensão e abrir uma conexão de rede com o seu servidor.
     *
     * @var string $priority
     */
    private $priority;

    /**
     * No iOS, use esse campo para representar content-available na carga útil do APNs.
     * Quando uma notificação ou mensagem é enviada e esse parâmetro é definido como true, um aplicativo cliente
     * inativo é acionado. No Android, por padrão, as mensagens de dados acionam o aplicativo.
     * Ainda não há compatibilidade com o Chrome.
     *
     * @var boolean $content_available
     */
    private $content_available;

    /**
     * Quando esse parâmetro é definido como true, a mensagem não deve ser enviada até o dispositivo ficar ativo.
     *
     * O valor padrão é false.
     *
     * @var boolean $delay_while_idle
     */
    private $delay_while_idle;

    /**
     * Este parâmetro especifica por quanto tempo (em segundos) a mensagem deve ser mantida no armazenamento do FCM
     * se o dispositivo ficar off-line. A vida útil máxima permitida é 4 semanas, que também é o valor padrão.
     *
     * @var integer $time_to_live
     */
    private $time_to_live;

    /**
     * Este parâmetro especifica o nome do pacote do aplicativo cujos tokens de registro
     * devem corresponder para receber a mensagem.
     *
     * @var string $restricted_package_name
     */
    private $restricted_package_name;

    /**
     * Quando definido como true, este parâmetro permite aos desenvolvedores testarem uma solicitação
     * sem de fato enviar uma mensagem.
     *
     * O valor padrão é false.
     *
     * @var boolean $dry_run
     */
    private $dry_run;

    /* Carga útil */

    /**
     * Este parâmetro especifica os pares chave-valor personalizados da carga útil da mensagem.
     *
     * No iOS, se a mensagem é enviada por meio do APNs, ela representa campos de dados personalizados.
     * Se ela for enviada pelo servidor de conexão do FCM, ela será representada como um dicionário de chave-valor
     * em AppDelegate application:didReceiveRemoteNotification:.
     *
     * São recomendados valores em tipos de string. É preciso converter os valores nos objetos ou outros
     * tipos de dados sem string (por exemplo, números inteiros ou booleanos) para string.
     *
     * @var array $data
     */
    private $data;

    /**
     * Este parâmetro especifica os pares chave-valor predefinidos da carga útil da notificação visíveis ao usuário.
     *
     * @var Notification $notification
     */
    private $notification;


    /**
     * Message constructor.
     */
    public function __construct()
    {
        $this->priority = FCM::MESSAGE_PRIORITY_NORMAL;
    }


    /* Getters e Setters */

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic($topic)
    {
        if ($topic)
            $this->topic = '/topics/' . $topic;
        else
            $this->topic = $topic;
    }

    /**
     * @return array
     */
    public function getRegistrationIds()
    {
        return $this->registration_ids;
    }

    /**
     * @param array $registration_ids
     */
    public function setRegistrationIds($registration_ids)
    {
        $this->registration_ids = $registration_ids;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @param string $condition
     */
    public function addCondition($condition)
    {
        $this->condition = '\'' . $condition . '\' in topics';
    }

    /**
     * @param string $condition
     */
    public function addAndCondition($condition)
    {
        $this->condition = ' && \'' . $condition . '\' in topics';
    }

    /**
     * @param string $condition
     */
    public function addOrCondition($condition)
    {
        $this->condition = ' || \'' . $condition . '\' in topics';
    }

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapse_key;
    }

    /**
     * @param string $collapse_key
     */
    public function setCollapseKey($collapse_key)
    {
        $this->collapse_key = $collapse_key;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return boolean
     */
    public function isContentAvailable()
    {
        return $this->content_available;
    }

    /**
     * @param boolean $content_available
     */
    public function setContentAvailable($content_available)
    {
        $this->content_available = $content_available;
    }

    /**
     * @return boolean
     */
    public function isDelayWhileIdle()
    {
        return $this->delay_while_idle;
    }

    /**
     * @param boolean $delay_while_idle
     */
    public function setDelayWhileIdle($delay_while_idle)
    {
        $this->delay_while_idle = $delay_while_idle;
    }

    /**
     * @return int
     */
    public function getTimeToLive()
    {
        return $this->time_to_live;
    }

    /**
     * @param int $time_to_live
     */
    public function setTimeToLive($time_to_live)
    {
        $this->time_to_live = $time_to_live;
    }

    /**
     * @return string
     */
    public function getRestrictedPackageName()
    {
        return $this->restricted_package_name;
    }

    /**
     * @param string $restricted_package_name
     */
    public function setRestrictedPackageName($restricted_package_name)
    {
        $this->restricted_package_name = $restricted_package_name;
    }

    /**
     * @return boolean
     */
    public function isDryRun()
    {
        return $this->dry_run;
    }

    /**
     * @param boolean $dry_run
     */
    public function setDryRun($dry_run)
    {
        $this->dry_run = $dry_run;
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
     * @param string $key
     * @param string $value
     */
    public function addDataParameter($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }
}