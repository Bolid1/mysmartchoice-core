<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFirmIntegrationRequest;
use App\Http\Requests\UpdateFirmIntegrationRequest;
use App\Http\Resources\FirmIntegrationResource;
use App\Managers\FirmIntegrationsManager;
use App\Models\Firm;
use App\Models\FirmIntegration;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use function abort_if;
use function data_get;

class FirmIntegrationsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FirmIntegration::class.',firm', 'firm_integration,firm');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Firm $firm): AnonymousResourceCollection
    {
        return FirmIntegrationResource::collection(
            $firm->integrationsInstalls()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFirmIntegrationRequest $request
     *
     * @return JsonResource
     */
    public function store(Firm $firm, StoreFirmIntegrationRequest $request, FirmIntegrationsManager $manager): JsonResource
    {
        Gate::check('manage-integrations', $firm);

        $firmIntegration = $manager->install($firm->id, data_get($request->validated(), 'integration_id'));

        abort_if(
            !$firmIntegration->save(),
            503,
            'Failed to save, try again later'
        );

        return FirmIntegrationResource::make($firmIntegration);
    }

    /**
     * Display the specified resource.
     *
     * @param  FirmIntegration $firmIntegration
     *
     * @return JsonResource
     */
    public function show(Firm $firm, FirmIntegration $firmIntegration): JsonResource
    {
        return FirmIntegrationResource::make($firmIntegration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateFirmIntegrationRequest $request
     * @param  FirmIntegration $firmIntegration
     *
     * @return JsonResource
     */
    public function update(Firm $firm, UpdateFirmIntegrationRequest $request, FirmIntegration $firmIntegration): JsonResource
    {
        Gate::check('manage-integrations', $firm);

        abort_if(!$firmIntegration->update($request->validated()), 503);

        return FirmIntegrationResource::make($firmIntegration);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FirmIntegration $firmIntegration
     *
     * @return JsonResource
     */
    public function destroy(Firm $firm, FirmIntegration $firmIntegration): JsonResource
    {
        Gate::check('manage-integrations', $firm);

        abort_if(!$firmIntegration->delete(), 503);

        return FirmIntegrationResource::make($firmIntegration);
    }
}
