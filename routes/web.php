<?php

declare(strict_types=1);

use App\Http\Controllers\OAuth\CallbacksController;
use App\Http\Controllers\Web;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', static fn () => Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => \PHP_VERSION,
]));

Route::get('/dashboard', [Web\FirmsController::class, 'index'])
     ->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('firms', Web\FirmsController::class)
    ->only([
        'show',
    ])
     ->middleware(['auth', 'verified']);

Route::resource('users', Web\UsersController::class)
    ->only([
        'edit',
        'update',
    ])
    ->middleware(['auth', 'verified']);

Route::resource('firms.users', Web\UsersController::class)
    ->only([
        'index',
    ])
    ->middleware(['auth', 'verified']);

Route::resource('firms.accounts', Web\AccountsController::class)
    ->middleware(['auth', 'verified']);

Route::resource('integrations', Web\IntegrationsController::class)
    ->middleware(['auth', 'verified']);

Route::resource('firms.firm_integrations', Web\FirmIntegrationsController::class)
    ->except('show')
    ->middleware(['auth', 'verified'])
;

Route::resource('o_auth_clients', Web\OAuthClientsController::class)
     ->middleware(['auth', 'verified'])
;

Route::middleware(['auth', 'verified'])->group(static function () {
    Route::prefix('/oauth')->group(static function () {
        Route::get(
            '/tokens',
            static fn () => Inertia::render('OAuth/Tokens')
        )->name('oauth.tokens.index');

        Route::get(
            '/tokens/issue',
            static fn () => Inertia::render('OAuth/TokenIssue')
        )->name('oauth.tokens.issue');

        Route::prefix('/callbacks')->group(static function () {
            Route::get('test_code', [CallbacksController::class, 'testCode'])
                 ->name('oauth.callbacks.test_code');
        });
    });
});
