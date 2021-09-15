<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\OAuth;

use App\Http\Controllers\Controller;
use App\Models\OAuth\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Laravel\Passport\Http\Controllers\ClientController;
use function inertia;

class ClientsController extends Controller
{
    private ClientController $controller;

    public function __construct(ClientController $controller)
    {
        $this->authorizeResource(Client::class);
        $this->controller = $controller;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        return inertia('OAuth/Clients', [
            'clients' => $this->controller->forUser($request)->map->setVisible([
                'id',
                'name',
                'redirect',
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return inertia('OAuth/ClientEdit', [
            'client' => Client::make([]),
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

        return Redirect::route('oauth.clients.edit', ['client' => $client], 303);
    }

    /**
     * Display the specified resource.
     *
     * @param  Client  $client
     *
     * @return Response
     */
    public function show(Client $client): Response
    {
        return inertia('OAuth/Client', [
            'client' => $client->makeVisible('secret'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Client  $client
     *
     * @return Response
     */
    public function edit(Client $client): Response
    {
        return inertia('OAuth/ClientEdit', [
            'client' => $client->makeVisible('secret'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Client  $client
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Client $client): RedirectResponse
    {
        $this->controller->update($request, $client->getKey());

        return Redirect::route('oauth.clients.edit', ['client' => $client], 303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Client $client
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Client $client): RedirectResponse
    {
        $this->controller->destroy($request, $client->getKey());

        return Redirect::route('oauth.clients.index', [], 303);
    }
}
