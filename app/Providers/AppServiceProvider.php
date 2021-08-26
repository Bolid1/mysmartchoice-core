<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\FirmIntegration;
use App\Observers\FirmIntegrationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        FirmIntegration::observe(FirmIntegrationObserver::class);
    }
}
