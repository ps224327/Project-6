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

        // Check if the product already exists in the user's cart
        $existingCartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingCartItem) {
            // Update the quantity of the existing cart item
            $existingCartItem->quantity += $quantity ?: 1; // Add 1 to quantity if not provided
            $existingCartItem->save();
        } else {
            if ($productId) {
                // Create a new cart item only if product_id is provided
                $newCartItem = [
                    'product_id' => $productId,
                    'user_id' => $userId,
                    'quantity' => $quantity ?: 1, // Set a default quantity of 1 if not provided
                ];
                Cart::create($newCartItem);
            }
        }

        // Get the product name
        $product = Product::find($productId);
        $productName = $product ? $product->name : '';

        // Set the success alert message
        $message = $productName ? $productName . ' (' . $quantity . 'x) toegevoegd aan het winkelwagentje' : '';

        // Redirect back to the previous page with the success alert
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => $message,
            'autoClose' => true
        ]);
    }


    public function showCart()
    {
        $user = Auth::user();
        if (!$user) {
            // Handle error - user not authenticated
            return redirect()->route('login');
        }

        $userId = $user->id;
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return view('cart.cart', compact('cartItems'));
        }

        $cartItems = $cartItems->map(function ($cartItem) {
            $totalPrice = $cartItem->quantity * $cartItem->product->price;
            return [
                'id' => $cartItem->product->id,
                'name' => $cartItem->product->name,
                'image' => $cartItem->product->image,
                'description' => $cartItem->product->description,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
                'totalPrice' => $totalPrice
            ];
        });

        return view('cart.cart', compact('cartItems'));
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
