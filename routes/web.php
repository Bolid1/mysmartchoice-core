<?php

declare(strict_types=1);

use App\Http\Controllers\Web\FirmsController;
use App\Http\Controllers\Web\UsersController;
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

Route::get('/dashboard', [FirmsController::class, 'index'])
     ->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('firms', FirmsController::class)
    ->only([
        'show',
    ])
     ->middleware(['auth', 'verified']);

Route::resource('users', UsersController::class)
    ->only([
        'edit',
        'update',
    ])
    ->middleware(['auth', 'verified']);

Route::resource('firms.users', UsersController::class)
    ->only([
        'index',
    ])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
