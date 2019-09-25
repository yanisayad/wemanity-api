<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;



class ExceptionListener
{
    public function __construct(ContainerInterface $container)
    {
        $this->debug = $container->getParameter('kernel.debug');
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        $response  = new JsonResponse($exception->getMessage());

        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();
        }

        $response->setStatusCode($code);

        $display_message = $this->debug || Response::HTTP_INTERNAL_SERVER_ERROR !== $response->getStatusCode();
        $response->setData($display_message ? $exception->getMessage() : null);
        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 32],
        ];
    }
}
