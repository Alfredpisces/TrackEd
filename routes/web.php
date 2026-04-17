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

// Convenience shortcuts redirect to the real authenticated dashboards
Route::middleware('auth')->group(function () {
    Route::get('/admin',     fn () => redirect()->route('dashboard.admin'));
    Route::get('/head',      fn () => redirect()->route('dashboard.school-head'));
    Route::get('/counselor', fn () => redirect()->route('dashboard.counselor'));
    Route::get('/teacher',   fn () => redirect()->route('dashboard.teacher'));
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route(request()->user()->dashboardRouteName());
    })->name('dashboard');

    Route::get('/dashboard/admin', fn () => view('dashboards.admin'))
        ->name('dashboard.admin')
        ->middleware(EnsureRole::class . ':Admin');
    Route::get('/dashboard/school-head', fn () => view('dashboards.school-head'))
        ->name('dashboard.school-head')
        ->middleware(EnsureRole::class . ':School Head');
    Route::get('/dashboard/counselor', fn () => view('dashboards.counselor'))
        ->name('dashboard.counselor')
        ->middleware(EnsureRole::class . ':Counselor');
    Route::get('/dashboard/teacher', fn () => view('dashboards.teacher'))
        ->name('dashboard.teacher')
        ->middleware(EnsureRole::class . ':Teacher');

    Route::get('/teacher-performance', fn () => view('teacher-performance'))
        ->name('teacher-performance')
        ->middleware(EnsureRole::class . ':Teacher,School Head');
    Route::get('/student-behavior', fn () => view('student-behavior'))
        ->name('student-behavior')
        ->middleware(EnsureRole::class . ':Counselor');
    Route::get('/property-inventory', fn () => view('property-inventory'))
        ->name('property-inventory')
        ->middleware(EnsureRole::class . ':Admin,Teacher');

    /*
    |----------------------------------------------------------------------
    | Admin-only: user management & transfers
    |----------------------------------------------------------------------
    */
    Route::middleware(EnsureRole::class . ':Admin')
        ->prefix('admin')
        ->name('users.')
        ->group(function () {
            Route::get('/lis-sync',               fn () => view('admin.lis-sync'))->name('lis-sync');
            Route::get('/users',                  [UserController::class, 'index'])->name('index');
            Route::get('/users/create',           [UserController::class, 'create'])->name('create');
            Route::post('/users',                 [UserController::class, 'store'])->name('store');
            Route::get('/users/{user}/transfer',  [UserController::class, 'showTransfer'])->name('transfer');
            Route::post('/users/{user}/transfer', [UserController::class, 'transfer'])->name('doTransfer');
        });
});
