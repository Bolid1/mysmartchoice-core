<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Observers\FirmIntegrationObserver;
use App\Observers\FirmObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Firm::observe(FirmObserver::class);
        FirmIntegration::observe(FirmIntegrationObserver::class);
    }
}
