<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login.welcome');

// Route::middleware(['IsAdmin'])->group(function () {
//     Route::prefix('admin')->name('admin.')->group(function () {
//         // return view('#');
//     })->name('dashboard');
// });

Route::middleware(['IsLoggedIn'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/home', [UserController::class, 'home'])->name('home');
    Route::get('/about', [UserController::class, 'about'])->name('about');
    Route::get('/setJob', [UserController::class, 'set_job'])->name('set_job');
    Route::get('/confirmation', [UserController::class, 'confirmation'])->name('confirmation');
    Route::get('/kas', [UserController::class, 'kas'])->name('kas');
    Route::get('/historyKas', [UserController::class, 'historyKas'])->name('historyKas');
    Route::get('/warningLog', [UserController::class, 'warningLog'])->name('warningLog');
    Route::get('/payKas', [UserController::class, 'payKas'])->name('payKas');
    Route::get('/piketLog', [UserController::class, 'piketLog'])->name('piketLog');
    Route::get('/schedulePiket', [UserController::class, 'schedulePiket'])->name('schedulePiket');
});

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
