<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\FirmIntegrationResource;
use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\Integration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use function compact;
use function inertia;

class FirmIntegrationsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FirmIntegration::class);
    }

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

    public function store(Firm $firm, Integration $integration): RedirectResponse
    {
        $install = FirmIntegration::create(
            [
                'firm' => $firm,
                'integration' => $integration,
                'status' => FirmIntegration::STATUS_INSTALLED,
            ],
        );

        return Redirect::route(
            'firms.integrations.installs.edit',
            compact('firm', 'integration', 'install'),
            303
        );
    }

    public function edit(FirmIntegration $install): Response
    {
        FirmIntegrationResource::withoutWrapping();

        return inertia('FirmIntegrationEdit', [
            'install' => $install,
        ]);
    }

    public function update(Firm $firm, Integration $integration, FirmIntegration $install): RedirectResponse
    {
        FirmIntegrationResource::withoutWrapping();

        return Redirect::route(
            'firms.integrations.installs.edit',
            compact('firm', 'integration', 'install'),
            303
        );
    }
}
