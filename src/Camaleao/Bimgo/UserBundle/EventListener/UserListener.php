<?php

namespace Camaleao\Bimgo\UserBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class UserListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) { return; }

        if ($controller[0] instanceof Controller AND $controller[0]->getUser()) {
            $user = $controller[0]->getUser();
            //echo $user->getNome();
        }
    }
}
