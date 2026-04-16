<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureRole;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest-only routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',           fn () => view('dashboard'))->name('dashboard');
    Route::get('/teacher-performance', fn () => view('teacher-performance'))->name('teacher-performance');
    Route::get('/student-behavior',    fn () => view('student-behavior'))->name('student-behavior');
    Route::get('/property-inventory',  fn () => view('property-inventory'))->name('property-inventory');

    /*
    |----------------------------------------------------------------------
    | Admin-only: user management & transfers
    |----------------------------------------------------------------------
    */
    Route::middleware(EnsureRole::class . ':Admin')
        ->prefix('admin')
        ->name('users.')
        ->group(function () {
            Route::get('/users',                  [UserController::class, 'index'])->name('index');
            Route::get('/users/create',           [UserController::class, 'create'])->name('create');
            Route::post('/users',                 [UserController::class, 'store'])->name('store');
            Route::get('/users/{user}/transfer',  [UserController::class, 'showTransfer'])->name('transfer');
            Route::post('/users/{user}/transfer', [UserController::class, 'transfer'])->name('doTransfer');
        });
});
