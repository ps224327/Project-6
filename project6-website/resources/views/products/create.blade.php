    @extends('layouts.app')

    @section('content')
        <div class="flex justify-center items-center h-screen">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <form action="{{ url('/product') }}" method="POST" enctype="multipart/form-data"
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        <h1 class="text-2xl font-bold mb-4">Product aanmaken</h1>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Naam:</label>
                            <input type="text" name="name" id="name"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="barcode" class="block text-gray-700 text-sm font-bold mb-2">Barcode:</label>
                            <input type="text" name="barcode" id="barcode"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="description"
                                class="block text-gray-700 text-sm font-bold mb-2">Beschrijving:</label>
                            <textarea name="description" id="description"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Prijs:</label>
                            <input type="number" name="price" id="price"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                step="0.01" required>
                        </div>
                        <div class="mb-4">
                            <label for="image_url" class="block text-gray-700 text-sm font-bold mb-2">Afbeelding URL:</label>
                            <input type="text" name="image_url" id="image_url"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>                        
                </div>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label for="color" class="block text-gray-700 text-sm font-bold mb-2">Kleur:</label>
                        <input type="text" name="color" id="color"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="height_cm" class="block text-gray-700 text-sm font-bold mb-2">Hoogte (cm):</label>
                        <input type="number" name="height_cm" id="height_cm"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="width_cm" class="block text-gray-700 text-sm font-bold mb-2">Breedte (cm):</label>
                        <input type="number" name="width_cm" id="width_cm"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="depth_cm" class="block text-gray-700 text-sm font-bold mb-2">Lengte (cm):</label>
                        <input type="number" name="depth_cm" id="depth_cm"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="weight_gr" class="block text-gray-700 text-sm font-bold mb-2">Gewicht (gr):</label>
                        <input type="number" name="weight_gr" id="weight_gr"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Maak
                        aan</button>
                    </form>
                </div>
            </div>
        </div>
    @endsection
