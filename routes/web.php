<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

Route::get('/user', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');


//Register form
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Auth::routes();

// Display the login form
Route::get('/login', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');

// Handle the login form submission
Route::post('/login', [LoginController::class, 'login']);

// Logout the user
Route::any('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');




Route::middleware(['auth'])->group(function () {

//onboarding
Route::get('/onboarding', [HomeController::class, 'onboardingPage'])->name('onboarding');
Route::post('/onboarding', [HomeController::class, 'onboarding']);

//dashboard
Route::post('/user/personal', '\App\Http\Controllers\UserController@updatePersonalInfo')->name('user.personal.update');
Route::post('/user/security', '\App\Http\Controllers\UserController@updateSecurity')->name('user.security.update');
Route::post('/user/address', '\App\Http\Controllers\UserController@updateAddress')->name('user.address.update');
Route::get('/get-order-details/{order_id}', [App\Http\Controllers\OrderController::class, 'getOrderDetails']);

    // Routes for authenticated users
    Route::any('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::any('/search_results', [App\Http\Controllers\HomeController::class, 'searchResults'])->name('search_results');
    Route::get('/categories/{category_id}', [App\Http\Controllers\HomeController::class, 'showCategory'])->name('category.show');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::any('/search_results', [App\Http\Controllers\HomeController::class, 'searchResults'])->name('search_results');
Route::get('/categories/{category_id}', [App\Http\Controllers\HomeController::class, 'showCategory'])->name('category.show');

//Product page
Route::get('/products/{product_id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::post('/products/{product_id}/add-review', [App\Http\Controllers\ProductController::class, 'addReview'])->name('product.addReview');

//cart
Route::get('/cart', [App\Http\Controllers\CartController::class, 'viewCart'])->name('cart');
Route::post('/cart/products/add/{product}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/products/{product}/update', [App\Http\Controllers\CartController::class, 'updateCartItem'])->name('cart.update');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

//Checkout
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'showCheckoutForm'])->name('checkout.form');
// Process the order creation
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'createOrder'])->name('checkout.create');

//Register your business
Route::get('/business/register', [BusinessController::class, 'registerBusinessForm'])->name('register_business_form');
Route::post('/business/register', [BusinessController::class, 'registerBusiness'])->name('business.register');

//Business
Route::get('/business', [BusinessController::class, 'businessPage'])->name('business');
Route::post('/business', [BusinessController::class, 'businessPage'])->name('business');

Route::any('/business/products', [BusinessController::class, 'showProducts'])->name('business.products');
Route::post('/business/products/{product_id}', [BusinessController::class, 'update'])->name('business.products.edit');

Route::get('/checkout/card', [CheckoutController::class, 'showCardForm'])->name('checkout.cardForm');

});



