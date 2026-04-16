<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('auth.login'))->name('login');
Route::get('/register', fn () => view('auth.register'))->name('register');
Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
Route::get('/teacher-performance', fn () => view('teacher-performance'))->name('teacher-performance');
Route::get('/student-behavior', fn () => view('student-behavior'))->name('student-behavior');
Route::get('/property-inventory', fn () => view('property-inventory'))->name('property-inventory');
