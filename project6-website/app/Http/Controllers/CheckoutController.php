<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout', compact('cartItems', 'total'));
    }

    public function payment(Request $request)
    {
        // Handle the payment process here
        // ...

        // Get the authenticated user
        $user = auth()->user();

        // Retrieve the cart items for the user
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        $insufficientStockProducts = [];

        // Check and reduce the stock for each product in the cart
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;

            // Check if the product has enough stock
            if ($product->stock >= $cartItem->quantity) {
                $product->stock -= $cartItem->quantity;
                $product->save();
            } else {
                // Add the product to the list of insufficient stock products
                $insufficientStockProducts[] = $product->name;
            }
        }

        if (!empty($insufficientStockProducts)) {
            // Handle insufficient stock error and specify the products
            $message = 'Insufficient stock for the following product(s): ' . implode(', ', $insufficientStockProducts);

            return redirect()->route('cart.show')->with('alert', [
                'type' => 'error',
                'message' => $message,
                'autoClose' => false
            ]);            
        } else {
            // Clear the cart after successful payment
            Cart::where('user_id', $user->id)->delete();
        }

        return redirect()->route('thankyou');
    }


    public function thankyou()
    {
        return view('thankyou');
    }
}
