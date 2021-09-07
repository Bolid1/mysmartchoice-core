<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntegrationRequest;
use App\Http\Requests\UpdateIntegrationRequest;
use App\Models\Integration;
use App\Models\User;
use App\Repositories\IntegrationsRepository;
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

    public function index(Request $request, IntegrationsRepository $repository): Response
    {
        /** @var User $user */
        $user = $request->user();

        return inertia('Integrations/Integrations', [
            'integrations' => $repository->getAvailableFor($user->id)->get(),
        ]);
    }

    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        return inertia('Integrations/IntegrationEdit', [
            'integration' => Integration::make(['owner_id' => $user->id]),
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
        return inertia('Integrations/Integration', [
            'integration' => $integration,
        ]);
    }

    public function edit(Integration $integration): Response
    {
        return inertia('Integrations/IntegrationEdit', [
            'integration' => $integration,
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
