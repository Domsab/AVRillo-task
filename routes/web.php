<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\KanyeRestMiddleware;
use App\Http\Controllers\KanyeRestController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => !Auth::user(),
        'canRegister' => !Auth::user(),
        'canLogout' => Auth::user() && Route::has('login'),
        'canGetQuote' => Auth::user() && Route::has('api.kanye-rest.index'),
        'apiToken' => Auth::user()?->api_token,
    ]);
})->name('welcome');

Route::middleware(KanyeRestMiddleware::class)->group(function () {
    Route::get('/kanye-rest-quotes', [KanyeRestController::class, 'index'])
        ->name('api.kanye-rest.index')->middleware(['auth', 'verified']);

    Route::get('/kanye-rest-refresh', [KanyeRestController::class, 'create'])
        ->name('api.kanye-rest.create');
});

require __DIR__ . '/auth.php';
