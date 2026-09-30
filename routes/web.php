<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.auth');
})->name('login');

// Route::middleware(['IsAdmin'])->group(function () {
//     Route::prefix('admin')->name('admin.')->group(function () {
//         // return view('#');
//     })->name('dashboard');
// });

Route::middleware(['IsGuest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/login', [UserController::class, 'login'])->name('login.store')->middleware('throttle:5.1');
    Route::post('/register', [UserController::class, 'register'])->name('register.store')->middleware('throttle:5.1');
});

Route::get('/home', [UserController::class, 'home'])->name('home');
