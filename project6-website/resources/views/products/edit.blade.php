@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    @method('PUT')
                    <h1 class="text-2xl font-bold mb-4">Bewerk Product</h1>
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Naam:</label>
                        <input type="text" name="name" id="name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ $product->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="barcode" class="font-bold">Barcode:</label>
                        <input type="text" name="barcode" id="barcode"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ $product->barcode }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="font-bold">Beschrijving:</label>
                        <textarea name="description" id="description"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>{{ $product->description }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="font-bold">Prijs:</label>
                        <input type="text" name="price" id="price"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ $product->price }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="image_url" class="font-bold">Afbeelding URL:</label>
                        <input type="text" name="image_url" id="image_url" value="{{ $product->image }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>                                      
            </div>
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label for="color" class="font-bold">Kleur:</label>
                    <input type="text" name="color" id="color"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ $product->color }}" required>
                </div>
                <div class="mb-4">
                    <label for="height_cm" class="font-bold">Hoogte (cm):</label>
                    <input type="number" name="height_cm" id="height_cm"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ $product->height_cm }}" required>
                </div>
                <div class="mb-4">
                    <label for="width_cm" class="font-bold">Breedte (cm):</label>
                    <input type="number" name="width_cm" id="width_cm"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ $product->width_cm }}" required>
                </div>
                <div class="mb-4">
                    <label for="depth_cm" class="font-bold">Lengte (cm):</label>
                    <input type="number" name="depth_cm" id="depth_cm"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ $product->depth_cm }}" required>
                </div>
                <div class="mb-4">
                    <label for="weight_gr" class="font-bold">Gewicht (gr):</label>
                    <input type="number" name="weight_gr" id="weight_gr"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ $product->weight_gr }}" required>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Bewerk
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
