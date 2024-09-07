<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-API-TOKEN');
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->get('X-API-TOKEN');

        if (!$apiToken) {
            throw new CustomUserMessageAuthenticationException('API Token ot found in the request.');
        }

        if ($apiToken !== $_ENV['API_TOKEN']) {
            throw new CustomUserMessageAuthenticationException('API Token is invalid.');
        }

        return new SelfValidatingPassport(new UserBadge($apiToken, function ($token) {
            // Check the API token against the one stored in .env
            if ($token === $_ENV['API_TOKEN']) {
                return new class () implements UserInterface {
                    public function getRoles(): array
                    {
                        return ['ROLE_API'];
                    }

                    public function eraseCredentials(): void
                    {
                    }

                    public function getUserIdentifier(): string
                    {
                        return '';
                    }
                };
            }

            throw new AuthenticationException('Invalid API token');
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }
}
