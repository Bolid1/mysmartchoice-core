<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFirmIntegrationRequest;
use App\Http\Requests\UpdateFirmIntegrationRequest;
use App\Managers\FirmIntegrationsManager;
use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\Token;
use App\Repositories\IntegrationsRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use function abort_if;
use function compact;
use function data_get;
use function inertia;
use function json_encode;
use const JSON_THROW_ON_ERROR;

class FirmIntegrationsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FirmIntegration::class.',firm', 'firm_integration,firm');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Firm $firm
     *
     * @return Response
     */
    public function index(Firm $firm, IntegrationsRepository $repository): Response
    {
        return inertia('Firms/FirmIntegrations', [
            'firm' => $firm,
            'integrations_installs' => $firm->integrationsInstalls->loadMissing('integration'),
            'integrations' => $repository->getAvailableFor(Auth::id())->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Firm $firm
     * @param StoreFirmIntegrationRequest $request
     * @param FirmIntegrationsManager $manager
     *
     * @return RedirectResponse
     */
    public function store(Firm $firm, StoreFirmIntegrationRequest $request, FirmIntegrationsManager $manager): RedirectResponse
    {
        Gate::authorize('manage-integrations', $firm);

        $firmIntegration = $manager->install($firm->id, data_get($request->validated(), 'integration_id'));

        abort_if(
            !$firmIntegration->save(),
            503,
            'Failed to save, try again later'
        );

        return Redirect::route(
            'firms.firm_integrations.edit',
            ['firm_integration' => $firmIntegration, 'firm' => $firm],
            303
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Firm $firm
     * @param FirmIntegration $firmIntegration
     *
     * @return Response
     */
    public function edit(Firm $firm, FirmIntegration $firmIntegration): Response
    {
        Gate::authorize('manage-integrations', $firm);

        $integration = $firmIntegration->integration;

        return inertia('Firms/FirmIntegrationEdit', [
            'firm' => $firm,
            'install' => $firmIntegration,
            'integration' => $integration,
            'tokens' => $integration->o_auth2_client_id
                ? Token::whereUserId(Auth::id())
                ->where('revoked', false)
                ->where('client_id', $integration->o_auth2_client_id)
                ->get()
                ->whereFirm($firm->id)
                ->loadMissing('client')
                ->values()
                : [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Firm $firm
     * @param UpdateFirmIntegrationRequest $request
     * @param FirmIntegration $firmIntegration
     *
     * @return RedirectResponse
     */
    public function update(Firm $firm, UpdateFirmIntegrationRequest $request, FirmIntegration $firmIntegration): RedirectResponse
    {
        Gate::authorize('manage-integrations', $firm);

        $firmIntegration->update($request->validated());

        return Redirect::route(
            'firms.firm_integrations.edit',
            ['firm_integration' => $firmIntegration, 'firm' => $firmIntegration->firm_id],
            303
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Firm $firm
     * @param FirmIntegration $firmIntegration
     *
     * @return RedirectResponse
     */
    public function destroy(Firm $firm, FirmIntegration $firmIntegration): RedirectResponse
    {
        Gate::authorize('manage-integrations', $firm);

        $firmIntegration->delete();

        return Redirect::route('firms.firm_integrations.index', compact('firm'), 303);
    }

    public function auth(Firm $firm, FirmIntegration $firmIntegration): RedirectResponse
    {
        $integration = $firmIntegration->integration;
        $client = $integration->client;

        //if ($integration->auth === Integration::AUTH_OAUTH2) {
        // @TODO: Another auth methods
        //}

        return Redirect::route(
            'authorizations.authorize',
            [
                'client_id' => $client->id,
                'redirect_uri' => $client->redirect,
                'response_type' => 'code',
                'scope' => $integration->oauth2ScopesFor($firm->id),
                'state' => json_encode([
                    'client_id' => $client->id,
                    'interface' => null,
                    'user_id' => Auth::id(),
                    'firm_id' => $firm->id,
                ], JSON_THROW_ON_ERROR),
            ],
            303
        );
    }
}
