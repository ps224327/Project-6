<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\products;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Product;
use App\Http\Requests;


class ProductController extends Controller
{
   
    function index() {
         /**    
        $token = '19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ';
        $url = "https://kuin.summaict.nl/api/product";
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->withOptions([
            'verify' => false,
        ])->get($url);

        $products = collect($response->json());
      //  dd($products);
    
        return view('product', compact('products'));
        */
        $products = products::all();
        foreach ($products as $product) {
            $barcode = rand(100000, 999999); // Generate random 6-digit barcode
            $product->barcode = $barcode;
            $product->save();
        }
        
    }
}
