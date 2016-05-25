<?php

namespace Camaleao\Bimgo\ApiBundle\EventListener;

use Camaleao\Bimgo\ApiBundle\Controller\ApiController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ApiListener
{
    private $api_key;

    public function __construct($tokens)
    {
        $this->api_key = $tokens['api_key'];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ApiController) {
            $api_key = $event->getRequest()->headers->get('api_key');
            if ($api_key != $this->api_key) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }
        }
    }
}
