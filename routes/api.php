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

Route::apiResource('firms', Api\FirmsController::class)
     ->only([
         'index',
         'show',
     ])
     ->names([
         'index' => 'api.firms.index',
         'show' => 'api.firms.show',
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
