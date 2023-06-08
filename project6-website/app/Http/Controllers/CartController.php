<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addItem(Request $request)
    {
        // Retrieve the product ID and quantity from the request
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            // Handle error - user not authenticated
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Meld u aan om producten toe te voegen aan het winkelwagentje.',
                'autoClose' => true
            ]);
        }

        // Retrieve the user ID
        $userId = $user->id;

        // Find the cart for the user or create a new one if it doesn't exist
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        // Check if the cart already contains the product
        $existingCartItem = $cart->where('product_id', $productId)->first();
        if ($existingCartItem) {
            // Update the quantity of the existing cart item
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            // Create a new cart item
            $newCartItem = [
                'product_id' => $productId,
                'user_id' => $userId,
                'quantity' => $quantity,
            ];
            Cart::create($newCartItem);
        }

        // Get the product name
        $product = Product::find($productId);
        $productName = $product->name;

        // Set the success alert message
        $message = '' . $productName . ' (' . $quantity . 'x) toegevoegd aan het winkelwagentje';

        // Redirect back to the previous page with the success alert
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => $message,
            'autoClose' => true
        ]);
    }

    public function showCart()
    {
        $token = getenv('API_KEY');
        $url = "http://kuin.summaict.nl/api/product";

        $user = Auth::user();
        if (!$user) {
            // Handle error - user not authenticated
            return redirect()->route('login');
        }

        $userId = $user->id;

        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return view('cart', compact('cartItems'));
        }

        $productIds = $cartItems->pluck('product_id')->toArray();
        $response = Http::withToken($token)->get($url, ['ids' => $productIds]);

        if ($response->successful()) {
            $products = $response->json();
            $cartItems = $cartItems->map(function ($cartItem) use ($products) {
                $product = collect($products)->firstWhere('id', $cartItem->product_id);
                $totalPrice = $cartItem->quantity * $product['price'];
                return [
                    'id' => $cartItem->product_id,
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'description' => $product['description'],
                    'quantity' => $cartItem->quantity,
                    'price' => $product['price'],
                    'totalPrice' => $totalPrice
                ];
            });

            return view('cart', compact('cartItems'));
        } else {
            // Handle error response
            return response()->json(['message' => 'Error retrieving products'], $response->status());
        }
    }


    public function updateItem(Request $request, $id)
    {
        $action = $request->input('action');

        $user = Auth::user();
        if (!$user) {
            // Handle error - user not authenticated
            return redirect()->route('login');
        }

        $userId = $user->id;

        $cartItem = Cart::where('user_id', $userId)->where('product_id', $id)->first();
        if (!$cartItem) {
            // Handle error - cart item not found
            return redirect()->route('cart.show')->with('alert', [
                'type' => 'error',
                'message' => 'Cart item not found',
                'autoClose' => false
            ]);
        }

        if ($action === 'decrease') {
            $cartItem->quantity--;
        } elseif ($action === 'increase') {
            $cartItem->quantity++;
        }

        if ($cartItem->quantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->save();
        }

        return redirect()->route('cart.show');
    }

    public function removeItem($productId)
    {
        $user = Auth::user();
        if (!$user) {
            // Handle error - user not authenticated
            return redirect()->route('login');
        }

        $userId = $user->id;

        $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
        if (!$cartItem) {
            // Handle error - cart item not found
            return redirect()->route('cart.show')->with('alert', [
                'type' => 'error',
                'message' => 'Cart item not found',
                'autoClose' => false
            ]);
        }

        $cartItem->delete();

        return redirect()->route('cart.show');
    }
}
