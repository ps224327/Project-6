<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MapController;



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

// Search Function
Route::get('/search', [ProductController::class, 'search'])->name('product.search');

// Cart 
Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
Route::get('/cart', [CartController::class , 'showCart'])->name('cart.show');

// Map 








