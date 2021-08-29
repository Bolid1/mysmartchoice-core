<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\SendOAuthCodeJob;
use App\Models\FirmIntegration;
use App\Models\Integration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use function array_map;
use function str_replace;

class FirmIntegrationObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the FirmIntegration "created" event.
     *
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return void
     */
    public function created(FirmIntegration $firmIntegration): void
    {
        if ((Integration::AUTH_OAUTH2 === $firmIntegration->integration->auth) && ($userId = Auth::id())) {
            Bus::dispatch(new SendOAuthCodeJob(
                $userId,
                $firmIntegration->firm_id,
                $firmIntegration->integration->o_auth2_client_id,
                array_map(
                    static fn ($scope) => str_replace('{firm}', (string)$firmIntegration->firm_id, $scope),
                    $firmIntegration->integration->o_auth2_scopes
                )
            ));
        }

        Log::info('Firm integration created', [
            'user_id' => $userId ?? null,
            'firm_integration' => $firmIntegration->getAttributes(),
        ]);
    }

    /**
     * Handle the FirmIntegration "updated" event.
     *
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return void
     */
    public function updated(FirmIntegration $firmIntegration)
    {
    }

    /**
     * Handle the FirmIntegration "deleted" event.
     *
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return void
     */
    public function deleted(FirmIntegration $firmIntegration)
    {
    }

    /**
     * Handle the FirmIntegration "restored" event.
     *
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return void
     */
    public function restored(FirmIntegration $firmIntegration)
    {
    }

    /**
     * Handle the FirmIntegration "force deleted" event.
     *
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return void
     */
    public function forceDeleted(FirmIntegration $firmIntegration)
    {
    }
}
