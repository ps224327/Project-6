@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten</title>

</head>

<body class="bg-green-100">
    <header class="bg-gray-900 px-5">
        <nav class="flex items-center justify-between flex-wrap">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <a href="/">
                <img src="{{ asset('images/GroeneVingersLogo.png') }}" alt="Logo" href="/" class="w-20 pr-2">
                </a>
                <span class="font-bold text-xl"><a href="/">Groene Vingers</a></span>
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
                        Producten
                    </a>
                </div>
                <div>
                    {{-- Cart --}}
                    <a href="{{ route('cart.show') }}" class="relative">
                        <span class="bg-red-500 text-white font-bold rounded-full w-6 h-6 flex items-center justify-center absolute bottom-0 right-0 transform translate-x-1/2 translate-y-1/2
                            @php
                                $cartCount = array_sum(session('cart', []));
                            @endphp
                            @if ($cartCount === 0)
                                hidden
                            @endif
                            ">
                            {{ $cartCount }}
                        </span>
                        <span class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
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
                        Aanmelden
                    </a>
                    {{-- Signup --}}
                    <a href="/signup"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-4 rounded border-green-800">
                        Registreren
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-5">
        <div class="flex items-center justify-between">
            <h2 class="text-5xl font-bold">{{ $product['name'] }}</h2>
        </div>
        <div class="flex mt-4">
            <div class="w-1/2">
                <img src="{{ $product['image'] }}" alt="{{ $product['image'] }}" class="object-cover w-full h-full">
            </div>
            <div class="w-1/2 ml-8">
                <div>
                    <p><span class="font-bold">Beschrijving:</span> {{ $product['description'] }}</p>
                    <p><span class="font-bold">Prijs:</span> &euro;{{ $product['price'] }}</p>
                    <p><span class="font-bold">Kleur:</span> {{ $product['color'] }}</p>
                    <p><span class="font-bold">Dimensies (cm):</span> 
                        Hoogte {{ $product['height_cm'] }} cm 
                        x Breedte {{ $product['width_cm'] }} cm 
                        x Lengte {{ $product['depth_cm'] }} cm</p>
                    <p><span class="font-bold">Gewicht (g):</span> {{ $product['weight_gr'] }} Gram</p>
                </div>
                <form method="POST" action="{{ route('cart.add') }}" class="flex gap-4 items-center mt-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <div>
                        <label for="quantity" class="font-bold">Aantal:</label>
                        <input type="number" name="quantity" value="1" min="1" max="10" class="w-10 outline-none bg-green-100">
                    </div>
                    <button type="submit" class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Voeg toe</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
