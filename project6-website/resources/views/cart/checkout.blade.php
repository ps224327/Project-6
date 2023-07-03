@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <form action="{{ route('checkout.payment') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <h2 class="text-2xl font-bold mb-6">Overzicht bestelling</h2>
            @foreach ($cartItems as $cartItem)
                <div class="flex items-center mb-4">
                    <img src="{{ $cartItem->product->image }}" alt="{{ $cartItem->product->name }}" class="w-20 h-20 mr-4">
                    <div>
                        <h3 class="text-lg font-bold">{{ $cartItem->product->name }}</h3>
                        <p class="text-gray-600">Aantal: {{ $cartItem->quantity }}</p>
                    </div>
                </div>
            @endforeach
            <p class="font-bold mb-6">Totaal: &euro;{{ number_format($total, 2) }}</p>
            <div class="flex items-center justify-between">
                <a href="{{ route('cart.show') }}"
                    class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Terug
                </a>
                <button
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Betalen
                </button>
            </div>
        </form>
    </div>
@endsection
