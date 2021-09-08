<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FirmIntegrationResource;
use App\Models\Firm;
use App\Models\FirmIntegration;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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
}
