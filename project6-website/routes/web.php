<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EmployeeController;

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

// Protected Routes (Requires authentication and role-based middleware)
// Employee CRUD
Route::middleware('can:webAdmin')->group(function () {
    Route::get('/medewerkers', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/medewerkers/toevoegen', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/medewerkers', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/medewerker/{employee}/verander', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/medewerker/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/medewerker/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

// Protected Routes (Requires authentication and role-based middleware)
// Product CRUD
Route::middleware('webAdminOrEmployee')->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/product', [ProductController::class, 'store'])->name('products.store');
    Route::get('/product/{product}/bewerk', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/product/dashboard', [ProductController::class, 'dashboard'])->name('products.dashboard');
});

// Show Products
Route::get('/producten', [ProductController::class, 'fetchImagesFromApiProducts'])->name('products');
Route::get('/', [ProductController::class, 'fetchImagesFromApiHome'])->name('home');
Route::get('/producten/{id}', [ProductController::class, 'show'])->name('product.show');

// Search / Filter Function
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/filter', [ProductController::class, 'filterProducts'])->name('products.filter');

// Cart
Route::post('/cart/add-item', [CartController::class, 'addItem'])->name('cart.add');
Route::get('/winkelwagentje', [CartController::class, 'showCart'])->name('cart.show');
Route::patch('/cart/update/{id}', [CartController::class, 'updateItem'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

// Checkout / Address
Route::get('/betalen', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/bedankt', [CheckoutController::class, 'thankyou'])->name('cart.thankyou');

Route::get('/address', function () {
    return view('cart.address');
})->name('cart.address');
Route::post('/checkout/process', [CheckoutController::class, 'payment'])->name('checkout.process');

// Map 
Route::get('/contact', [MapController::class, 'showMap'])->name('contact');
// Route::get('/route/{lat1}/{lng1}/{lat2}/{lng2}', [MapController::class, 'getRoute'])->name('getRoute');

// Webhook
Route::post('/webhook', [WebhookController::class, 'handleWebhook']);

// Login / Signup
Route::get('/aanmelden', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/aanmelden', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registreren', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/registreren', [AuthController::class, 'signup'])->name('signup');

Route::get('/signup/success', [AuthController::class, 'signupSuccess'])->name('signup.success');

// Profile
Route::get('/profiel', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
