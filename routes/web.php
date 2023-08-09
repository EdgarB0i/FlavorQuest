<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RestaurantviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpdateRestaurantController;
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

// Homepage
Route::get('/home', function (Request $request) {
    return view('home', ['username' => $request->input('username')]);
})->name('home');

// Routing for logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Add Restaurant route
Route::group(['middleware' => 'admin'], function () {
    Route::get('/add-restaurant', [RestaurantController::class, 'showAddRestaurantForm'])->name('restaurant.add');
    Route::post('/add-restaurant', [RestaurantController::class, 'store'])->name('restaurant.store');
});

// Add Offer route
Route::group(['middleware' => 'admin'], function () {
    Route::get('/add-offer', [OfferController::class, 'showAddOfferForm'])->name('offer.add');
    Route::post('/add-offer', [OfferController::class, 'store'])->name('offer.store');
});

// Update restaurant details
Route::group(['middleware' => 'admin'], function () {
    Route::get('/update', [UpdateRestaurantController::class, 'showUpdateForm'])->name('update.form');
    Route::post('/update', [UpdateRestaurantController::class, 'updateRestaurant'])->name('update.restaurant');
});



// Route to show restaurant details, with optional location parameter
Route::get('/restaurants/{name}/{location?}', [RestaurantviewController::class, 'showRestaurantDetails'])->name('restaurant.view');



// This is a test page
Route::get('/test', function () {
    return view('test');
});
