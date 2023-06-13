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
Route::get('/producten', [ProductController::class, 'fetchImagesFromApiProducts'])->name('products');
Route::get('/', [ProductController::class, 'fetchImagesFromApiHome'])->name('home');
Route::get('/producten/{id}', [ProductController::class, 'show'])->name('product.show');

// Search / Filter Function
Route::get('/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/filter', [ProductController::class, 'filterProducts'])->name('products.filter');

// Cart
Route::post('/cart/add-item', [CartController::class, 'addItem'])->name('cart.add');
Route::get('/winkelwagentje', [CartController::class, 'showCart'])->name('cart.show');
Route::patch('/cart/update/{id}', [CartController::class, 'updateItem'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

// Checkout / Address
Route::get('/betalen', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/bedankt', [CheckoutController::class, 'thankyou'])->name('thankyou');

Route::get('/address', function () {
    return view('address');
})->name('address');
Route::post('/checkout/process', [CheckoutController::class, 'payment'])->name('checkout.process');

// Map 
Route::get('/contact', [MapController::class, 'showMap'])->name('contact');
// Route::get('/route/{lat1}/{lng1}/{lat2}/{lng2}', [MapController::class, 'getRoute'])->name('getRoute');

// Webhook
Route::post('/webhook', [WebhookController::class, 'handleWebhook']);

// Login / Signup
Route::get('/aanmelden', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/aanmelden', [AuthController::class, 'login'])->name('login');

Route::get('/registreren', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/registreren', [AuthController::class, 'signup'])->name('signup');

Route::get('/signup/success', [AuthController::class, 'signupSuccess'])->name('signup.success');

// Profile
Route::get('/profiel', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
