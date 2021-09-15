<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\OAuth;

use App\Http\Controllers\Controller;
use App\Http\Resources\OAuth\ClientResource;
use App\Models\OAuth\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\Http\Controllers\ClientController;

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
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ClientResource::collection(
            $this->controller->forUser($request)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResource
     */
    public function store(Request $request): JsonResource
    {
        return ClientResource::make($this->controller->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  Client $client
     *
     * @return JsonResource
     */
    public function show(Client $client): JsonResource
    {
        return ClientResource::make($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Client $client
     *
     * @return JsonResource
     */
    public function update(Request $request, Client $client): JsonResource
    {
        return ClientResource::make($this->controller->update($request, $client->getKey()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client $client
     *
     * @return JsonResource
     */
    public function destroy(Request $request, Client $client): JsonResource
    {
        $this->controller->destroy($request, $client->getKey());

        return ClientResource::make($client);
    }
}
