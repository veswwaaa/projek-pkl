<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenController;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/register', function () {
//     return view('auth.register');
// });

Route::controller(AuthenController::class)->group(function () {
    Route::get('/registration', [AuthenController::class, 'registration'])->middleware('alreadyLoggedIn');
    Route::post('/registration-user', [AuthenController::class, 'registerUser'])->name('register-user');
    Route::get('/login', [AuthenController::class, 'login'])->middleware('alreadyLoggedIn');
    Route::post('/login-user', [AuthenController::class, 'loginUser'])->name('login-user');
    Route::get('/dashboard', [AuthenController::class, 'dashboard'])->middleware('isLoggedIn');
    Route::get('/logout', [AuthenController::class, 'logout']);
});