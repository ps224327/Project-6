@extends('layouts.app')

@section('content')

        <div class="relative">
            <div class="bg-cover bg-center h-96" style="background-image: url('{{ asset('images/intratuin.png') }}');">
            </div>
            <div class="absolute top-10 left-0 flex flex-col justify-top h-max w-max bg-white bg-opacity-50 py-8 px-8">
                <div class="flex text-black mb-4">
                    <p class="pr-4">Nuenen <br> 2587 WD <br> Tuinstraat 167</p>
                    <p class="pr-4">Zwanenburg <br> 1161 AM <br> Kruiswaal 16</p>
                    <p>Soesterberg <br> 3769 DH <br> Kampweg 47</p>
                </div>
                <div class="center">
                    <a href="/contact"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg rounded-l-lg 
                        border border-gray-200 w-32 text-center">Contact</a>
                </div>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-center py-5">Producten</h1>

        <div class="w-full px-4">
            <div class="grid grid-cols-5 gap-5">
                @php
                    $alert = session('alert');
                @endphp

                @include('_alert')

                @foreach ($products->random(5) as $product)
                    <div class="relative">
                        <a href="{{ route('product.show', ['id' => $product['id']]) }}" class="block overflow-hidden h-max">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                                class="object-cover w-full h-full">
                        </a>
                        <div class="p-4 bg-white shadow-lg rounded-lg flex flex-col justify-between">
                            <div class="mb-2">
                                <h2 class="text-lg font-bold mb-2 overflow-hidden whitespace-nowrap overflow-ellipsis"
                                >{{ $product['name'] }}</h2>
                            </div>
                            <div class="flex gap-4 items-center">
                                <div class="flex gap-4 justify-between items-start">
                                    <div class="flex flex-col items-center">
                                        <label for="price" class="font-bold">Prijs:</label>
                                        <p class="text-black">&euro;{{ $product['price'] }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('cart.add') }}"
                                        class="flex gap-4 items-center justify-evenly">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                        <div class="flex flex-col items-center">
                                            <label for="quantity" class="font-bold">Aantal:</label>
                                            <input type="number" name="quantity" value="1" min="1"
                                                max="10" class="w-10 outline-none">
                                        </div>
                                        <button type="submit"
                                            class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                            Voeg toe</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-center items-center py-5">
            <a href="/producten"
                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg rounded-l-lg 
                        border border-green-800 w-32 text-center">Meer Zien</a>
        </div>

@endsection
