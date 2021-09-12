<?php

declare(strict_types=1);

namespace App\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Controllers\AuthorizationController as PassportController;
use Laravel\Passport\TokenRepository;
use Psr\Http\Message\ServerRequestInterface;
use function collect;
use function csrf_token;
use function inertia;

class AuthorizationController extends PassportController
{
    public function authorize(
        ServerRequestInterface $psrRequest,
        Request $request,
        ClientRepository $clients,
        TokenRepository $tokens
    ): Response|\Illuminate\Http\Response {
        $authRequest = $this->withErrorHandling(function () use ($psrRequest) {
            return $this->server->validateAuthorizationRequest($psrRequest);
        });

        $scopes = $this->parseScopes($authRequest);

        $token = $tokens->findValidToken(
            $user = $request->user(),
            $client = $clients->find($authRequest->getClient()->getIdentifier())
        );

        if (($token && $token->scopes === collect($scopes)->pluck('id')->all()) ||
            $client->skipsAuthorization()) {
            return $this->approveRequest($authRequest, $user);
        }

        $request->session()->put('authToken', $authToken = Str::random());
        $request->session()->put('authRequest', $authRequest);

        return inertia('OAuth/Authorize', [
            'client' => $client,
            'user' => $user,
            'scopes' => $scopes,
            'request' => $request,
            'auth_token' => $authToken,
            'csrf_token' => csrf_token(),
        ]);
    }
}
