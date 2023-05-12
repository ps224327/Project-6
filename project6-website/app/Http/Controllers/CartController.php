<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addItem(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $url = "http://kuin.summaict.nl/api/product";
        $token = '19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ';

        $cart = session('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        session(['cart' => $cart]);

        $product = Http::withToken($token)->get($url . $productId)->json();
        $message = $quantity . ' ' . $product['name'] . ' added to cart';
        return redirect()->back()->with('success', $message);
    }

    public function showCart()
    {
        $token = '19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ';
        $url = "http://kuin.summaict.nl/api/product";
        $cart = session('cart', []);

        $productIds = collect($cart)->keys()->toArray();
        $response = Http::withToken($token)->get($url, [
            'ids' => $productIds,
        ]);

        if ($response->successful()) {
            $products = $response->json();
            $cartItems = collect($cart)->map(function ($quantity, $productId) use ($products) {
                $product = collect($products)->firstWhere('id', $productId);
                $totalPrice = $quantity * $product['price'];
                return [
                    'id' => $productId,
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'description' => $product['description'],
                    'quantity' => $quantity,
                    'price' => $product['price'],
                    'totalPrice' => $totalPrice
                ];
            })->values();
            return view('cart', ['cartItems' => $cartItems]);
        } else {
            // Handle error response
            return response()->json(['message' => 'Error retrieving products'], $response->status());
        }
    }

    public function updateItem(Request $request, $id)
    {
        $action = $request->input('action');
        $cart = session('cart', []);
        $quantity = $cart[$id] ?? 0;

        if ($action === 'decrease') {
            $quantity--;
        } elseif ($action === 'increase') {
            $quantity++;
        }

        if ($quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $quantity;
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.show');
    }


    public function removeItem($productId)
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return redirect()->route('cart.show');
    }
}
