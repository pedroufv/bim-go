<?php

namespace Camaleao\Bimgo\ApiBundle\EventListener;

use Camaleao\Bimgo\ApiBundle\Controller\ApiController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ApiListener
{
    private $apikey;

    public function __construct($options)
    {
        $this->apikey = $options['apikey'];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ApiController) {
            $apikey = $event->getRequest()->headers->get('apikey');
            if ($apikey != $this->apikey) {
                throw new AccessDeniedHttpException('Acesso negado!');
            }
        }
    }
}
