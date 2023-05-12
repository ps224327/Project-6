<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <!-- Fontawesome -->
    <link rel="stylesheet"
        href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">

    <title>cart</title>
</head>

<body>
    <header class="bg-gray-900 px-5">
        <nav class="flex items-center justify-between flex-wrap py-6">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <span class="font-bold text-xl">GroeneVingers</span>
            </div>
            <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                <div class="text-sm lg:flex-grow">
                    <a href="/" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                        Home
                    </a>
                    <a href="/contact" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                        Contact
                    </a>
                    <a href="/products" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                        Products
                    </a>
                </div>
                <div>
                    {{-- Cart --}}
                    <a href="{{ route('cart.show') }}" class="relative">
                        <span
                            class="bg-red-500 text-white font-bold rounded-full w-6 h-6 flex items-center justify-center absolute bottom-0 right-0 transform translate-x-1/2 translate-y-1/2">
                            {{ array_sum(session('cart', [])) }}
                        </span>
                        <span class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </span>
                    </a>


                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif
                    {{-- Login --}}
                    <a href="/login"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-4 rounded border-green-800">
                        Log In
                    </a>
                    {{-- Signup --}}
                    <a href="/signup"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-4 rounded border-green-800">
                        Sign Up
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
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
                                    <img src="{{ $cartItem['image'] }}" alt="{{ $cartItem['name'] }}" width="100"
                                        class="mr-4">
                                    <div>
                                        <h2 class="font-bold">{{ $cartItem['name'] }}</h2>
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
                            <td class="border px-4 py-2">&euro;{{ $cartItem['price'] }}</td>
                            <td class="border px-4 py-2">&euro;{{ number_format($cartItem['totalPrice'], 2) }}</td>
                            <td class="border px-4 py-2">
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
    <td class="px-4 py-2" colspan="3">Total:</td>
    <td class="px-4 py-2">&euro;{{ number_format($cartItems->sum('totalPrice'), 2) }}</td>
    <td></td>
    </tr>
    </tfoot>
    </table>
@else
    <p>Your cart is empty</p>
    @endif

    </div>

    </body>

</html>
