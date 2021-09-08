<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Account;
use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\Integration;
use App\Models\OAuthClient;
use App\Models\Token;
use App\Models\User;
use App\Policies\AccountPolicy;
use App\Policies\FirmIntegrationPolicy;
use App\Policies\FirmPolicy;
use App\Policies\IntegrationPolicy;
use App\Policies\OAuthClientPolicy;
use App\Policies\UserPolicy;
use App\Repositories\ScopeRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Bridge\ScopeRepository as PassportScopeRepository;
use Laravel\Passport\Passport;
use function config;

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
        OAuthClient::class => OAuthClientPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function register(): void
    {
        $this->app->bind(PassportScopeRepository::class, ScopeRepository::class);
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::useClientModel(OAuthClient::class);
        Passport::useTokenModel(Token::class);

        Passport::tokensCan(config('oauth.scopes.plain'));
        /*
         * Dynamic scopes in config('oauth.scopes.patterns')
         * @see \App\Services\DynamicScopesBuilder::$scopesPatterns
         */

        if (!$this->app->routesAreCached()) {
            Passport::routes(null, [
                'prefix' => 'api/oauth',
            ]);
        }
    }
}
