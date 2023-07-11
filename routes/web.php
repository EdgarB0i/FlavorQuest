<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

// Routing for signup
Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup', [SignupController::class, 'register'])->name('signup.register');

// Routing for login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

//homepage
Route::get('/home', function(Request $request) {
    return view('home', ['username' => $request->input('username')]);
})->name('home');


// Routing for logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


//this is a test page
Route::get('/test', function () {
    return view('test');
});