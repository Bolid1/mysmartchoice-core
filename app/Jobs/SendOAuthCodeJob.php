<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\ScopeRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JsonException;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\User;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Nyholm\Psr7\Response as Psr7Response;
use function json_encode;
use const JSON_THROW_ON_ERROR;

class SendOAuthCodeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private int    $userId;
    private string $clientId;
    private array  $scopes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, string $clientId, array $scopes)
    {
        $this->userId = $userId;
        $this->clientId = $clientId;
        $this->scopes = $scopes;
    }

    /**
     * Execute the job.
     *
     * @param AuthorizationServer $server
     * @param ClientRepository $clientRepository
     * @param ScopeRepository $scopeRepository
     *
     * @return void
     *
     * @throws JsonException
     */
    public function handle(AuthorizationServer $server, ClientRepository $clientRepository, ScopeRepository $scopeRepository): void
    {
        Log::info('New '.__CLASS__, [
            'user_id' => $this->userId,
            'client_id' => $this->clientId,
            'scopes' => $this->scopes,
        ]);

        if (!$client = $clientRepository->getClientEntity($this->clientId)) {
            Log::error('Client not found by identifier', [
                'user_id' => $this->userId,
                'client_id' => $this->clientId,
                'scopes' => $this->scopes,
            ]);

            return;
        }

        if (!$user = \App\Models\User::find($this->userId)) {
            Log::error('User not found by identifier', [
                'user_id' => $this->userId,
                'client_id' => $this->clientId,
                'scopes' => $this->scopes,
            ]);

            return;
        }

        $authorizationRequest = new AuthorizationRequest();

        $authorizationRequest->setAuthorizationApproved(true);
        $authorizationRequest->setClient($client);
        // $authorizationRequest->setCodeChallenge();
        // $authorizationRequest->setCodeChallengeMethod();
        $authorizationRequest->setGrantTypeId('authorization_code');
        // $authorizationRequest->setRedirectUri();
        $authorizationRequest->setScopes($scopeRepository->getScopesEntitiesByIdentifiers($this->scopes));
        $authorizationRequest->setState(
            json_encode([
                'client_id' => $this->clientId,
                'interface' => null,
            ], JSON_THROW_ON_ERROR)
        );
        $authorizationRequest->setUser(new User($user->getAuthIdentifier()));

        $location = (string)Arr::first(
            $server
                ->completeAuthorizationRequest($authorizationRequest, new Psr7Response())
                ->getHeader('Location')
        );

        Log::info('Location for code sending is built', [
            'user_id' => $this->userId,
            'client_id' => $this->clientId,
            'scopes' => $this->scopes,
            'location' => $location,
        ]);

        if ($location) {
            $response = Http::get($location);

            Log::debug('Request completed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    }
}
