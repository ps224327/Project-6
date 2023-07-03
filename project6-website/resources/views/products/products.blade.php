@extends('layouts.app')

@section('content')
        <div class="container mx-auto my-8">
            <h1 class="text-2xl font-bold mb-4">Producten</h1>
            <div class="flex flex-wrap">
                <div class="w-full lg:w-1/4 px-4">
                    <h2 class="text-lg font-bold mb-2">Filters</h2>

                    {{-- Search --}}

                    <form method="GET" action="{{ route('products.search') }}" class="mb-4 flex flex-col">
                        <label class="text-gray-700 font-bold mb-2" for="search">Zoeken</label>
                        <div class="relative flex">
                            <input type="text" name="search" id="search"
                                class="shadow appearance-none border rounded-l w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Zoek...">
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r ml-2">
                                <i class="fas fa-search"></i>
                            </button>
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

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="sort">Sorteren op prijs</label>
                            <select name="sort" id="sort"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Normaal</option>
                                <option value="low-to-high" {{ request('sort') == 'low-to-high' ? 'selected' : '' }}>Prijs:
                                    Laag naar Hoog</option>
                                <option value="high-to-low" {{ request('sort') == 'high-to-low' ? 'selected' : '' }}>Prijs:
                                    Hoog naar Laag</option>
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
                                        class="object-cover w-full h-full" data-src="{{ $product->image }}">
                                </a>
                                <div class="p-4 bg-white shadow-lg rounded-lg flex flex-col justify-between">
                                    <div class="mb-2">
                                        <h2
                                            class="text-lg font-bold mb-2 overflow-hidden whitespace-nowrap overflow-ellipsis">
                                            {{ $product->name }}</h2>
                                    </div>
                                    <div class="flex gap-4 justify-between items-start">
                                        <div class="flex flex-col items-center">
                                            <label for="price" class="font-bold">Prijs:</label>
                                            <p class="text-black">&euro;{{ $product->price }}</p>
                                        </div>
                                        <form method="POST" action="{{ route('cart.add') }}"
                                            class="flex gap-4 items-center justify-evenly">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="flex flex-col items-center">
                                                <label for="quantity" class="font-bold">Aantal:</label>
                                                <input type="number" name="quantity" value="1" min="1"
                                                    class="w-10 outline-none">
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

@endsection
