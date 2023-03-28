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

        $cart = session('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } 
        else {
            $cart[$productId] = $quantity;
        }
        session(['cart' => $cart]);

        $product = Http::withToken('19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ')->get('https://kuin.summaict.nl/api/product/' . $productId)->json();
        $message = $quantity . ' ' . $product['name'] . ' added to cart';
        return redirect()->back()->with('success', $message);
    }
    public function showCart()
    {
        $cart = session('cart', []);
        $productIds = collect($cart)->keys()->toArray();
        $response = Http::withToken('19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ')->get('https://kuin.summaict.nl/api/product', [
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
}
