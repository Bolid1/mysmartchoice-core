<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\OAuthClientResource;
use App\Models\OAuthClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Laravel\Passport\Http\Controllers\ClientController;
use function inertia;

class OAuthClientsController extends Controller
{
    private ClientController $controller;

    public function __construct(ClientController $controller)
    {
        $this->authorizeResource(OAuthClient::class, 'oauth_client');
        $this->controller = $controller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        return inertia('OAuth/Clients', [
            'oauth_clients' => OAuthClientResource::collection(
                $this->controller->forUser($request)
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        OAuthClientResource::withoutWrapping();

        return inertia('OAuth/ClientEdit', [
            'client' => OAuthClientResource::make(OAuthClient::make([])),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $client = $this->controller->store($request);

        return Redirect::route('oauth_clients.edit', ['oauth_client' => $client], 303);
    }

    /**
     * Display the specified resource.
     *
     * @param  OAuthClient  $oAuthClient
     *
     * @return Response
     */
    public function show(OAuthClient $oAuthClient): Response
    {
        OAuthClientResource::withoutWrapping();

        return inertia('OAuth/Client', [
            'client' => OAuthClientResource::make($oAuthClient->makeVisible('secret')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OAuthClient  $oAuthClient
     *
     * @return Response
     */
    public function edit(OAuthClient $oAuthClient): Response
    {
        OAuthClientResource::withoutWrapping();

        return inertia('OAuth/ClientEdit', [
            'client' => OAuthClientResource::make($oAuthClient->makeVisible('secret')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param OAuthClient  $oAuthClient
     *
     * @return RedirectResponse
     */
    public function update(Request $request, OAuthClient $oAuthClient): RedirectResponse
    {
        $this->controller->update($request, $oAuthClient->getKey());

        return Redirect::route('oauth_clients.edit', ['oauth_client' => $oAuthClient], 303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OAuthClient  $oAuthClient
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, OAuthClient $oAuthClient): RedirectResponse
    {
        $this->controller->destroy($request, $oAuthClient->getKey());

        return Redirect::route('oauth_clients.index', [], 303);
    }
}
