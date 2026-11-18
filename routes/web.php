<?php

use App\Http\Controllers\piketScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login.welcome');

// Route::get('/', [RoomController::class, 'landing'])->name('landing');

// Route::middleware(['IsAdmin'])->group(function () {
//     Route::prefix('admin')->name('admin.')->group(function () {
//         // return view('#');
//     })->name('dashboard');
// });

Route::middleware(['IsLoggedIn'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/home', [UserController::class, 'home'])->name('home');
    Route::get('/about', [UserController::class, 'about'])->name('about');
    Route::get('/absent-students', [UserController::class, 'absentStudents'])->name('absent_students');
    Route::get('/schedulePiket/piket', [UserController::class, 'set_job'])->name('schedulePiket.piket');
    Route::get('/api/piket-data', [UserController::class, 'piketData'])->name('api.piket.data');
    Route::get('/confirmation', [UserController::class, 'confirmation'])->name('confirmation')->middleware('IsAdmin');
    Route::post('/attendance/{id}/confirm', [UserController::class, 'confirmAttendance'])->name('attendance.confirm')->middleware('IsAdmin');
    Route::get('/kas', [UserController::class, 'kas'])->name('kas');
    Route::get('/historyKas', [UserController::class, 'historyKas'])->name('historyKas');
    Route::get('/warningLog', [UserController::class, 'warningLog'])->name('warningLog');
    Route::get('/payKas', [UserController::class, 'payKas'])->name('payKas');
    Route::get('/piketLog', [UserController::class, 'piketLog'])->name('piketLog');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');

    Route::post('/attendance', [UserController::class, 'attendance'])->name('attendance');

    // route untuk CRUD jadwal piket
    Route::get('/piket-schedule/{id}', [piketScheduleController::class, 'edit'])->name('piketSchedule.edit');
    Route::put('/piket-schedule/{id}', [piketScheduleController::class, 'update'])->name('piketSchedule.update');
    Route::delete('/piket-schedule/{id}', [piketScheduleController::class, 'destroy'])->name('piketSchedule.destroy');
    Route::get('/piket-schedule', [piketScheduleController::class, 'index'])->name('piketSchedule.index');
    Route::post('/piket-schedule', [piketScheduleController::class, 'store'])->name('piketSchedule.store');

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

// Route publik untuk fitur room (bisa diakses guest maupun user login)
Route::post('/room/join', [RoomController::class, 'join'])->name('room.join');
Route::get('/room/{room}', [RoomController::class, 'show'])->name('room.show');
