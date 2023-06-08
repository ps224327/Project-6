@extends('layouts.app')

@section('content')

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
@endsection
