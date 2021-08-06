<?php

declare(strict_types=1);

use App\Http\Controllers;
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
Route::apiResource('users', Controllers\Api\UsersController::class)
     ->only([
         'index',
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

Route::apiResource('firms', Controllers\Api\FirmsController::class)
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
