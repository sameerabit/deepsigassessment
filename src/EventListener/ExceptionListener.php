<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        // Determine if the exception is an authentication or access denial issue
        if ($exception instanceof AuthenticationException) {
            $response = new JsonResponse([
                'status' => 'error',
                'message' => 'Full authentication is required to access this resource.',
            ], Response::HTTP_UNAUTHORIZED);
        } elseif ($exception instanceof AccessDeniedException) {
            $response = new JsonResponse([
                'status' => 'error',
                'message' => 'Access denied.',
            ], Response::HTTP_FORBIDDEN);
        } else {
            // Handle other exceptions as JSON
            $response = new JsonResponse([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Set the JSON response
        $event->setResponse($response);
    }
}
