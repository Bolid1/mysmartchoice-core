<?php

declare(strict_types=1);

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\Models\OAuthClient;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\ClientRepository;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Throwable;
use function abort_if;
use function app;
use function class_exists;
use function http_build_query;
use function json_decode;
use function route;
use const JSON_THROW_ON_ERROR;

class CallbacksController extends Controller
{
    public function testCode(Request $request, ClientRepository $repository): RedirectResponse
    {
        try {
            $request->query->set(
                'state',
                json_decode(
                    (string)$request->input('state', '{"client_id":"none"}'),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );
        } catch (Throwable $exception) {
            Log::notice(
                'Failed to decode state',
                [
                    'state' => $request->input('state'),
                    'exception' => $exception->getMessage(),
                ],
            );
        }

        $data = $request->validate([
            'code' => 'required|string|min:10',
            'state.client_id' => 'required|string|required|min:10',
            'state.interface' => 'string',
        ]);

        /** @var OAuthClient $client */
        $client = $repository->findActive($data['state']['client_id']);

        abort_if(!$client, 422, 'Client not found');

        Gate::check('test-exchange', $client);

        $tokenRequest = Request::create(
            route('passport.token'),
            'POST',
            $body = [
                'grant_type' => 'authorization_code',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'redirect_uri' => $client->redirect,
                'code' => $data['code'],
            ],
            [],
            [],
            [],
            http_build_query($body)
        );

        // Replace standard realization only for ability to provide own-created request
        app()->bind(ServerRequestInterface::class, function () use ($tokenRequest) {
            if (class_exists(Psr17Factory::class) && class_exists(PsrHttpFactory::class)) {
                $psr17Factory = new Psr17Factory();

                return (new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory))
                    ->createRequest($tokenRequest);
            }

            throw new BindingResolutionException(
                'Unable to resolve PSR request. Please install the symfony/psr-http-message-bridge and nyholm/psr7 packages.'
            );
        });

        /*$response = */ Route::dispatchToRoute($tokenRequest);

        //if ($response instanceof \Illuminate\Http\Response) {
        //    $json = \json_decode((string) $response->getContent(), true);
        //    $json = [
        //        'token_type' => 'Bearer',
        //        'expires_in' => 31536000,
        //        'access_token' => 'eyJ0eXAiO...',
        //        'refresh_token' => 'def5020...',
        //    ];
        //}

        return empty($data['state']['interface'])
            ? Redirect::route('oauth.tokens.index', [], 303)
            : Redirect::to($data['state']['interface'], 303);
    }
}
