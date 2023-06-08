@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">winkelwagentje</h1>
        <i class="fa-solid fa-cart-shopping"></i>
        @if (count($cartItems) > 0)
            <table class="border-collapse w-full">
                <thead>
                    <tr class="text-left bg-gray-100">
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2 text-center">Aantal</th>
                        <th class="px-4 py-2 text-center">Prijs</th>
                        <th class="px-4 py-2 text-center">Totale Prijs</th>
                        <th class="px-4 py-2 text-center">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td class="border px-4 py-2">
                                <div class="flex items-center">
                                    <a href="{{ route('product.show', ['id' => $cartItem['id']]) }}">
                                        <img src="{{ $cartItem['image'] }}" alt="{{ $cartItem['name'] }}" width="100" class="mr-4">
                                    </a>                                    
                                    <div class="w-3/4">
                                        <a href="{{ route('product.show', ['id' => $cartItem['id']]) }}">
                                        <h2 class="font-bold">{{ $cartItem['name'] }}</h2>
                                        </a>
                                        <p class="text-gray-700">{{ $cartItem['description'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="border px-4 py-2">
                                <form method="POST" action="{{ route('cart.update', ['id' => $cartItem['id']]) }}">
                                    @csrf
                                    @method('PUT')
                                    <form method="POST" action="{{ route('cart.update', ['id' => $cartItem['id']]) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex items-center">
                                            <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                                    name="action" value="decrease">-</button>
                                            <input type="number" name="quantity" id="quantity_{{ $cartItem['id'] }}"
                                                   value="{{ $cartItem['quantity'] }}" readonly
                                                   class="form-input w-16 mx-2 text-center">
                                            <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                                    name="action" value="increase">+</button>
                                        </div>
                                    </form>
                            </td>
                            <td class="border px-4 py-2 text-center">&euro;{{ $cartItem['price'] }}</td>
                            <td class="border px-4 py-2 text-center">&euro;{{ number_format($cartItem['totalPrice'], 2) }}</td>
                            <td class="border px-4 py-2 text-center">
                                <form action="{{ route('cart.remove', $cartItem['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">Verwijder</button>
                                </form>
                            </td>
                        </tr> @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100">
                        <td class="px-4 py-2" colspan="3">Totaal:</td>
                        <td class="px-4 py-2">&euro;{{ number_format($cartItems->sum('totalPrice'), 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="mt-4">
                <a href="{{ route('checkout') }}"
                   class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Bestellen</a>
            </div>
        @else
        <p>Uw winkelwagentje is leeg!</p>
        @endif

        </div>
@endsection
