<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OAuthClientResource;
use App\Models\OAuthClient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\Http\Controllers\ClientController;

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
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return OAuthClientResource::collection(
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
        return OAuthClientResource::make($this->controller->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  OAuthClient $oAuthClient
     *
     * @return JsonResource
     */
    public function show(OAuthClient $oAuthClient): JsonResource
    {
        return OAuthClientResource::make($oAuthClient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  OAuthClient $oAuthClient
     *
     * @return JsonResource
     */
    public function update(Request $request, OAuthClient $oAuthClient): JsonResource
    {
        return OAuthClientResource::make($this->controller->update($request, $oAuthClient->getKey()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OAuthClient $oAuthClient
     *
     * @return JsonResource
     */
    public function destroy(Request $request, OAuthClient $oAuthClient): JsonResource
    {
        $this->controller->destroy($request, $oAuthClient->getKey());

        return OAuthClientResource::make($oAuthClient);
    }
}
