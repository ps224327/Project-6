<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Show Products products.blade.php
    public function fetchImagesFromApiProducts(Request $request)
    {
        $token = '19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ';
        $search = $request->input('search');
        $url = "https://kuin.summaict.nl/api/product/search/{$search}";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->withOptions([
            'verify' => false,
        ])->get($url);

        $products = collect($response->json());
        // dd($images);

        // Paginate the results
        $products = DB::table('products')->paginate(20);

        return view('products', ['products' => $products, 'search' => $search]);
    }
    

    // Show Products home.blade.php
    public function fetchImagesFromApiHome()
    {
        $token = '19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ';
        $url = "https://kuin.summaict.nl/api/product";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->withOptions([
            'verify' => false,
        ])->get($url);

        $products = collect($response->json());
        // dd($images);

        return view('home', ['products' => $products]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $products = DB::table('products')->where('name', 'LIKE', "%{$search}%")->paginate(20);

        return view('products', ['products' => $products]);
    }


    public function getProduct($id)
    {
        $product = Product::find($id);
        return view('product', ['product' => $product]);
    }
}
