<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\CheckoutController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/contact', function () {
    return view('contact'); 
});

// Show Products
Route::get('/products', [ProductController::class, 'fetchImagesFromApiProducts'])->name('products');
Route::get('/', [ProductController::class, 'fetchImagesFromApiHome'])->name('home');    
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

// Search / Filter Function
Route::get('/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/filter', [ProductController::class, 'filterProducts'])->name('products.filter');

// Cart
Route::post('/cart/add-item', [CartController::class, 'addItem'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::patch('/cart/update/{id}', [CartController::class, 'updateItem'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/thankyou', [CheckoutController::class, 'thankyou'])->name('thankyou');

// Map 
Route::get('/contact', [MapController::class, 'showMap'])->name('contact');
// Route::get('/route/{lat1}/{lng1}/{lat2}/{lng2}', [MapController::class, 'getRoute'])->name('getRoute');

// Webhook
Route::post('/webhook', [WebhookController::class, 'handleWebhook']);

// Login / Signup
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

Route::get('/signup/success', [AuthController::class, 'signupSuccess'])->name('signup.success');

// Profile
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


