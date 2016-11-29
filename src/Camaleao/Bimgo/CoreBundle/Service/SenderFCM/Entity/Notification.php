<?php

namespace Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Entity;

use Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Model\FCM;

/**
 * Class Notification
 *
 * Representa a notificação enviada dentro de uma mensagem aos servidores FCM
 *
 * @package Camaleao\Animallovers\ApiBundle\Services\SenderFCM\Entity
 */
class Notification
{
    /**
     * Indica o título da notificação. Este campo não é visível nos celulares e tablets iOS.
     *
     * @var string $title
     */
    private $title;

    /**
     * Indica o texto do corpo da notificação.
     *
     * @var string $body
     */
    private $body;

    /**
     * Indica o ícone da notificação. Define o valor como myicon para o recurso desenhável myicon.
     *
     * @var string $icon
     */
    private $icon;

    /**
     * Indica um som a ser reproduzido quando o dispositivo recebe uma notificação.
     * Compatível com default ou o nome de arquivo de um recurso de som empacotado no aplicativo.
     *
     * Os arquivos de som do Android devem residir em /res/raw/ e os arquivos de som do iOS podem estar
     * no pacote principal do aplicativo do cliente ou na pasta Library/Sounds do contêiner de dados do aplicativo.
     *
     * @var string $sound
     */
    private $sound;

    /**
     * Indica o indicador do ícone da página inicial do aplicativo cliente.
     *
     * @var string $badge
     */
    private $badge;

    /**
     * Indica se cada notificação resulta em uma nova entrada na gaveta de notificações do Android.
     * Se não estiver definida, cada solicitação criará uma nova notificação.
     * Se estiver definida e uma notificação com a mesma tag já estiver sendo mostrada, a nova notificação
     * substituirá a notificação existente na gaveta de notificações.
     *
     * @var string $tag
     */
    private $tag;

    /**
     * Indica a cor do ícone, expressa no formato #rrggbb.
     *
     * @var string $color
     */
    private $color;

    /**
     * Indica a ação associada a um clique do usuário na notificação.
     *
     * Se estiver definida no iOS, ela corresponderá a category na carga útil dos APNs.
     *
     * No Android, se esse parâmetro estiver definido, uma atividade com um filtro de intenções correspondente
     * será iniciada quando o usuário clicar na notificação.
     *
     * @var string $click_action
     */
    private $click_action;

    /**
     * Indica a chave da string do corpo para localização.
     *
     * No iOS, corresponde a "loc-key" na carga útil do APNs.
     *
     * No Android, utilize a chave nos recursos de string do aplicativo ao preencher esse valor.
     *
     * @var string $body_loc_key
     */
    private $body_loc_key;

    /**
     * Indica o valor da string para substituir os especificadores de formato na string do corpo para localização.
     *
     * No iOS, corresponde a "loc-args" na carga útil dos APNs.
     *
     * No Android, esses são os argumentos de formato para os recursos da string.
     *
     * @var string|array $body_loc_args
     */
    private $body_loc_args;

    /**
     * Indica a chave da string do título para localização.
     *
     * No iOS, corresponde a "title-loc-key" na carga útil do APNs.
     *
     * No Android, utilize a chave nos recursos de string do aplicativo ao preencher esse valor.
     *
     * @var string $title_loc_key
     */
    private $title_loc_key;

    /**
     * Indica o valor da string para substituir os especificadores de formato na string do título para localização.
     *
     * No iOS, corresponde a "title-loc-args" na carga útil dos APNs.
     *
     * No Android, esses são os argumentos de formato para os recursos da string.
     *
     * @var string|array
     */
    private $title_loc_args;


    /**
     * Notification constructor.
     *
     * @param null $title
     * @param null $body
     */
    public function __construct($title = null, $body = null)
    {
        $this->title = $title;
        $this->body = $body;

        $this->icon = FCM::NOTIFICATION_ICON_DEFAULT;
        $this->sound = FCM::NOTIFICATION_SOUND_DEFAULT;
    }


    /* Getters e Setters */
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * @param string $sound
     */
    public function setSound($sound)
    {
        $this->sound = $sound;
    }

    /**
     * Desativa o som da notificação.
     */
    public function disableSound()
    {
        $this->sound = null;

        return $this;
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @param string $badge
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getClickAction()
    {
        return $this->click_action;
    }

    /**
     * @param string $click_action
     */
    public function setClickAction($click_action)
    {
        $this->click_action = $click_action;
    }

    /**
     * @return string
     */
    public function getBodyLocKey()
    {
        return $this->body_loc_key;
    }

    /**
     * @param string $body_loc_key
     */
    public function setBodyLocKey($body_loc_key)
    {
        $this->body_loc_key = $body_loc_key;
    }

    /**
     * @return array|string
     */
    public function getBodyLocArgs()
    {
        return $this->body_loc_args;
    }

    /**
     * @param array|string $body_loc_args
     */
    public function setBodyLocArgs($body_loc_args)
    {
        $this->body_loc_args = $body_loc_args;
    }

    /**
     * @return string
     */
    public function getTitleLocKey()
    {
        return $this->title_loc_key;
    }

    /**
     * @param string $title_loc_key
     */
    public function setTitleLocKey($title_loc_key)
    {
        $this->title_loc_key = $title_loc_key;
    }

    /**
     * @return array|string
     */
    public function getTitleLocArgs()
    {
        return $this->title_loc_args;
    }

    /**
     * @param array|string $title_loc_args
     */
    public function setTitleLocArgs($title_loc_args)
    {
        $this->title_loc_args = $title_loc_args;
    }
}