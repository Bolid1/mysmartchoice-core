<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFirmIntegrationRequest;
use App\Http\Requests\UpdateFirmIntegrationRequest;
use App\Http\Resources\FirmIntegrationResource;
use App\Http\Resources\FirmResource;
use App\Http\Resources\IntegrationResource;
use App\Managers\FirmIntegrationsManager;
use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\User;
use App\Repositories\IntegrationsRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use function abort_if;
use function compact;
use function data_get;
use function inertia;

class FirmIntegrationsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FirmIntegration::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Firm $firm, Request $request, IntegrationsRepository $repository): Response
    {
        FirmResource::withoutWrapping();

        /** @var User $user */
        $user = $request->user();

        return inertia('FirmIntegrations', [
            'firm' => FirmResource::make($firm),
            'firm_integrations' => FirmIntegrationResource::collection(
                $firm
                    ->integrationsInstalls()
                    ->with(
                        'integration',
                        // fixme: Why?
                        'firm',
                    )
                    ->paginate()
            ),
            'integrations' => IntegrationResource::collection(
                $repository->getAvailableFor($user->id)->paginate()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request, Firm $firm, IntegrationsRepository $repository): Response
    {
        Gate::check('manage-integrations', $firm);

        FirmResource::withoutWrapping();
        FirmIntegrationResource::withoutWrapping();

        /** @var User $user */
        $user = $request->user();

        return inertia('FirmIntegrationEdit', [
            'firm' => FirmResource::make($firm),
            'firm_integration' => FirmIntegrationResource::make(FirmIntegration::make([
                // todo: place default values here
            ])),
            'integrations' => IntegrationResource::collection(
                $repository->getAvailableFor($user->id)->paginate()
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreFirmIntegrationRequest $request
     *
     * @return RedirectResponse
     */
    public function store(Firm $firm, StoreFirmIntegrationRequest $request, FirmIntegrationsManager $manager): RedirectResponse
    {
        Gate::check('manage-integrations', $firm);

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
     * @param  FirmIntegration  $firmIntegration
     *
     * @return Response
     */
    public function edit(Request $request, Firm $firm, FirmIntegration $firmIntegration, IntegrationsRepository $repository): Response
    {
        Gate::check('manage-integrations', $firm);

        FirmResource::withoutWrapping();
        FirmIntegrationResource::withoutWrapping();

        /** @var User $user */
        $user = $request->user();

        return inertia('FirmIntegrationEdit', [
            'firm' => $firm,
            'firm_integration' => FirmIntegrationResource::make($firmIntegration),
            'integrations' => IntegrationResource::collection(
                $repository
                    ->getAvailableFor($user->id)
                    ->whereId($firmIntegration->integration_id)
                    ->paginate()
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateFirmIntegrationRequest $request
     * @param  FirmIntegration  $firmIntegration
     *
     * @return RedirectResponse
     */
    public function update(Firm $firm, UpdateFirmIntegrationRequest $request, FirmIntegration $firmIntegration): RedirectResponse
    {
        Gate::check('manage-integrations', $firm);

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
     * @param  FirmIntegration  $firmIntegration
     *
     * @return RedirectResponse
     */
    public function destroy(Firm $firm, FirmIntegration $firmIntegration): RedirectResponse
    {
        Gate::check('manage-integrations', $firm);

        $firmIntegration->delete();

        return Redirect::route('firms.firm_integrations.index', compact('firm'), 303);
    }
}
