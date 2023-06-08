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
        $token = getenv('API_KEY');
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
        $token = getenv('API_KEY');
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

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            // Handle error - product not found
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Product not found',
                'autoClose' => false
            ]);
        }

        return view('products.show', compact('product'));
    }

    public function filterProducts(Request $request)
    {
        $priceRange = $request->input('price');
        $sort = $request->input('sort');

        $products = Product::query();

        if ($priceRange) {
            if ($priceRange === '0-5') {
                $products->whereBetween('price', [0, 5]);
            } elseif ($priceRange === '5-10') {
                $products->whereBetween('price', [5, 10]);
            } elseif ($priceRange === '10-15') {
                $products->whereBetween('price', [10, 15]);
            } elseif ($priceRange === '15+') {
                $products->where('price', '>', 15);
            }
        }

        if ($sort === 'low-to-high') {
            $products->orderBy('price', 'asc');
        } elseif ($sort === 'high-to-low') {
            $products->orderBy('price', 'desc');
        }

        $filteredProducts = $products->paginate(20)->appends(['price' => $priceRange, 'sort' => $sort]);

        return view('products', ['products' => $filteredProducts]);
    }

    public function getProduct($id)
    {
        $product = Product::find($id);
        return view('product', ['product' => $product]);
    }
}
