<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntegrationRequest;
use App\Http\Requests\UpdateIntegrationRequest;
use App\Http\Resources\IntegrationResource;
use App\Models\Integration;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use function inertia;
use function redirect;
use function route;

class IntegrationsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Integration::class);
    }

    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        return inertia('Integrations', [
            'integrations' => IntegrationResource::collection(
                Integration::where('owner_id', $user->id)
                           ->orWhere('status', Integration::STATUS_AVAILABLE)
                           ->paginate()
            ),
        ]);
    }

    public function create(Request $request): Response
    {
        IntegrationResource::withoutWrapping();

        /** @var User $user */
        $user = $request->user();

        return inertia('IntegrationEdit', [
            'integration' => IntegrationResource::make(
                Integration::make(['owner_id' => $user->id])
            ),
        ]);
    }

    public function store(StoreIntegrationRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $integration = Integration::create(
            ['owner_id' => $user->id] + $request->validated()
        );

        return redirect(route('integrations.edit', $integration), 303);
    }

    public function show(Integration $integration): Response
    {
        IntegrationResource::withoutWrapping();

        return inertia('Integration', [
            'integration' => IntegrationResource::make($integration),
        ]);
    }

    public function edit(Request $request, Integration $integration): Response
    {
        /** @var User $user */
        $user = $request->user();

        IntegrationResource::withoutWrapping();

        return inertia('IntegrationEdit', [
            'integration' => IntegrationResource::make($integration),
            'oauth_clients' => $user->oauthClients()->paginate(),
        ]);
    }

    public function update(UpdateIntegrationRequest $request, Integration $integration): RedirectResponse
    {
        $integration->update($request->validated());

        return redirect(route('integrations.edit', $integration), 303);
    }

    public function destroy(Integration $integration): RedirectResponse
    {
        $integration->delete();

        return redirect(route('integrations.index'), 303);
    }
}
