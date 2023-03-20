<?php

use App\Http\Controllers\BarcodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;


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
    return view('welcome');
});

Route::get('/generate-barcodes', [BarcodeController::class, 'generateBarcodes']);
