<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Routing for signup
Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup', [SignupController::class, 'register'])->name('signup.register');

// Routing for login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Routing for homepage
Route::get('/home',function() {
    return view('home');
});