<?php

declare(strict_types=1);

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResource('users', Api\UsersController::class)
     ->only([
         'show',
         'update',
     ])
     ->names([
         'index' => 'api.users.index',
         'show' => 'api.users.show',
         'update' => 'api.users.update',
     ])
     ->middleware('auth:api')
;

Route::apiResource('firms.users', Api\UsersController::class)
     ->only([
         'index',
     ])
     ->names([
         'index' => 'api.firms.users.index',
     ])
     ->middleware('auth:api')
;

Route::apiResource('firms.accounts', Api\AccountsController::class)
     ->names([
         'index' => 'api.firms.accounts.index',
         'show' => 'api.firms.accounts.show',
         'store' => 'api.firms.accounts.store',
         'update' => 'api.firms.accounts.update',
         'destroy' => 'api.firms.accounts.destroy',
     ])
     ->middleware('auth:api')
;

Route::apiResource('integrations', Api\IntegrationsController::class)
     ->names([
         'index' => 'api.integrations.index',
         'show' => 'api.integrations.show',
         'store' => 'api.integrations.store',
         'update' => 'api.integrations.update',
         'destroy' => 'api.integrations.destroy',
     ])
     ->middleware('auth:api')
;

Route::apiResource('firms.firm_integrations', App\Http\Controllers\Api\FirmIntegrationsController::class)
     ->names([
         'index' => 'api.firms.firm_integrations.index',
         'show' => 'api.firms.firm_integrations.show',
         'store' => 'api.firms.firm_integrations.store',
         'update' => 'api.firms.firm_integrations.update',
         'destroy' => 'api.firms.firm_integrations.destroy',
     ])
     ->middleware('auth:api')
;

Route::apiResource('o_auth_clients', App\Http\Controllers\Api\OAuthClientsController::class)
     ->names([
         'index' => 'api.o_auth_clients.index',
         'show' => 'api.o_auth_clients.show',
         'store' => 'api.o_auth_clients.store',
         'update' => 'api.o_auth_clients.update',
         'destroy' => 'api.o_auth_clients.destroy',
     ])
     ->middleware('auth:api')
;

Route::middleware('auth:api')->group(static function () {
    Route::apiResource('firms', Api\FirmsController::class)
         ->names([
             'index' => 'api.firms.index',
             'show' => 'api.firms.show',
             'store' => 'api.firms.store',
             'update' => 'api.firms.update',
             'destroy' => 'api.firms.destroy',
         ])
    ;
});

