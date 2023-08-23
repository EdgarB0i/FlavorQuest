<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RestaurantviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpdateRestaurantController;
use App\Http\Controllers\RateRestaurantsController;
use App\Http\Controllers\RateDishesController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
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

// Routing for logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



// Homepage
Route::get('/home', [HomeController::class, 'index'])->name('home');



// Route to show restaurant details, with optional location parameter
Route::get('/restaurants/details/{name}/{location?}', [RestaurantviewController::class, 'showRestaurantDetails'])->name('restaurant.details');


//Route to rate restaurants
Route::get('/rate-restaurants', [RateRestaurantsController::class, 'show'])->name('rate.restaurants');
Route::post('/rate-restaurant', [RateRestaurantsController::class, 'rate'])->name('rate.restaurant');

//Route to rate dishes
Route::get('/rate-dishes', [RateDishesController::class, 'show'])->name('rate.dishes');
Route::get('/get-menu-items/{restaurant}', [RateDishesController::class, 'getMenuItems']);
Route::post('/rate-dishes', [RateDishesController::class, 'rateDishes'])->name('rate.dishes.submit');

//View the ratings
Route::get('/ratings', [RatingsController::class, 'showForm'])->name('ratings.show');
Route::get('/ratings/details/{id}', [RatingsController::class, 'viewDetails'])->name('ratings.details');
Route::post('/ratings/view-details', [RatingsController::class, 'searchAndRedirect'])->name('ratings.viewDetails');

//For review page
Route::get('/reviews/create/{restaurant}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews/{review}/upvote', [ReviewController::class, 'upvote'])->name('reviews.upvote');
Route::post('/reviews/{review}/downvote', [ReviewController::class, 'downvote'])->name('reviews.downvote');

//search
Route::get('/search', [SearchController::class,'search'])->name('web.search');
Route::get('/restaurants/details', [RestaurantController::class, 'showDetails'])->name('restaurant.det');


// Add Restaurant route
Route::group(['middleware' => 'admin'], function () {
    Route::get('/add-restaurant', [RestaurantController::class, 'showAddRestaurantForm'])->name('restaurant.add');
    Route::post('/add-restaurant', [RestaurantController::class, 'store'])->name('restaurant.store');
// Add Offer route
    Route::get('/add-offer', [OfferController::class, 'showAddOfferForm'])->name('offer.add');
    Route::post('/add-offer', [OfferController::class, 'store'])->name('offer.store');
// Update restaurant details
    Route::get('/update', [UpdateRestaurantController::class, 'showUpdateForm'])->name('update.form');
    Route::post('/update', [UpdateRestaurantController::class, 'updateRestaurant'])->name('update.restaurant');
});


// This is a test page
Route::get('/test', function () {
    return view('test');
});
