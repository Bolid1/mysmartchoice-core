<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Account;
use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\Integration;
use App\Models\User;
use App\Policies\AccountPolicy;
use App\Policies\FirmIntegrationPolicy;
use App\Policies\FirmPolicy;
use App\Policies\IntegrationPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Account::class => AccountPolicy::class,
        FirmIntegration::class => FirmIntegrationPolicy::class,
        Firm::class => FirmPolicy::class,
        Integration::class => IntegrationPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes(null, [
                'prefix' => 'api/oauth'
            ]);
        }
    }
}
