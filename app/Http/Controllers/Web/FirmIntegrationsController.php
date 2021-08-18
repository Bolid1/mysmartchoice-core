<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\FirmIntegrationResource;
use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\Integration;
use Inertia\Response;
use function inertia;

class FirmIntegrationsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FirmIntegration::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Firm $firm
     *
     * @return Response
     */
    public function create(Firm $firm, Integration $integration): Response
    {
        FirmIntegrationResource::withoutWrapping();

        return inertia('FirmIntegrationEdit', [
            'install' => FirmIntegrationResource::make(FirmIntegration::make([
                'firm' => $firm,
                'integration' => $integration,
            ])),
        ]);
    }
}
