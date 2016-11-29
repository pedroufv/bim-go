<?php

namespace Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Model;

interface FCM
{
    // constantes relacionadas à mensagem
    Const MESSAGE_PRIORITY_HIGHT = 'hight';
    Const MESSAGE_PRIORITY_NORMAL = 'normal';

    // constantes relacionadas à notificação
    Const NOTIFICATION_SOUND_DEFAULT = 'default';
    Const NOTIFICATION_ICON_DEFAULT = 'default';
}