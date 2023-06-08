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
        
        // Clear the cart after successful payment
        Cart::where('user_id', auth()->id())->delete();
        
        return redirect()->route('thankyou');
    }

    public function thankyou()
    {
        return view('thankyou');
    }
}
