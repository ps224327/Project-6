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
                        <img src="{{ asset('images/GroeneVingersLogo.png') }}" alt="Logo" href="/"
                            class="w-20 pr-2">
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
                            <span
                                class="bg-red-500 text-white font-bold rounded-full w-6 h-6 flex items-center justify-center absolute bottom-0 right-0 transform translate-x-1/2 translate-y-1/2
                            @php
$cartCount = array_sum(session('cart', [])); @endphp
                            @if ($cartCount === 0) hidden @endif
                            ">
                                {{ $cartCount }}
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
        <div class="container mx-auto my-8">
            <h1 class="text-2xl font-bold mb-4">Producten</h1>
            <div class="flex flex-wrap">
                <div class="w-full lg:w-1/4 px-4">
                    <h2 class="text-lg font-bold mb-2">Filters</h2>

                    {{-- Search --}}

                    <form method="GET" action="{{ route('product.search') }}" class="mb-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="search">Search</label>
                            <input type="text" name="search" id="search"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Search products...">
                        </div>
                        <div class="flex justify-center">
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Zoeken</button>
                        </div>
                    </form>


                    {{-- Price Filter --}}

                    <form action="{{ route('products.filter') }}" method="GET">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="price">Prijs</label>
                            <select name="price" id="price"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Alle prijzen</option>
                                <option value="0-5" {{ request('price') == '0-5' ? 'selected' : '' }}>€0 - €5</option>
                                <option value="5-10" {{ request('price') == '5-10' ? 'selected' : '' }}>€5 - €10</option>
                                <option value="10-15" {{ request('price') == '10-15' ? 'selected' : '' }}>€10 - €15
                                </option>
                                <option value="15+" {{ request('price') == '15+' ? 'selected' : '' }}>€15+</option>
                            </select>
                            
                        </div>

                        <button type="submit"
                            class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Filter</button>
                    </form>


                </div>

                {{-- Products --}}

                <div class="w-full lg:w-3/4 px-4">
                    <div class="grid grid-cols-4 gap-4">

                        @php
                            $alert = session('alert');
                        @endphp

                        @include('_alert')

                        @foreach ($products as $product)
                            <div class="relative">
                                <a href="{{ route('product.show', ['id' => $product->id]) }}"
                                    class="block overflow-hidden h-max">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                        class="object-cover w-full h-full">
                                </a>
                                <div class="p-4 bg-white shadow-lg rounded-lg flex flex-col justify-between">
                                    <div class="mb-2">
                                        <h2 class="text-lg font-bold mb-2">{{ $product->name }}</h2>
                                    </div>
                                    <div class="flex gap-4 justify-between items-start">
                                        <div class="mt-2 flex flex-col">
                                            <label for="price" class="font-bold">Prijs:</label>
                                            <p class="text-black">&euro;{{ $product->price }}</p>
                                        </div>
                                        <form method="POST" action="{{ route('cart.add') }}"
                                            class="flex gap-4 items-center justify-evenly">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div>
                                                <label for="quantity" class="font-bold">Aantal:</label>
                                                <input type="number" name="quantity" value="1" min="1"
                                                    max="10" class="w-10 outline-none">
                                            </div>
                                            <button type="submit"
                                                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Voeg
                                                toe</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="pagination flex justify-center items-center mt-8">
                        {{ $products->appends(['price' => request('price')])->links('vendor.pagination.tailwind') }}
                    </div>

    </body>

    </html>
@endsection
