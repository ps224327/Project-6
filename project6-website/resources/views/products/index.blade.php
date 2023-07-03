@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Products</h1>
        <!-- Search Bar -->
        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
            <div class="flex justify-end">
                <input type="text" name="search" value="{{ $search }}"
                    class="shadow appearance-none border rounded-l w-2/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Search...">
                <button type="submit"
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r ml-2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        @if (count($products) > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Afbeelding
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Afmetingen
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prijs
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span>Bewerk</span>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span>Verwijder</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-normal">
                                <div class="flex items-center">
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" width="100" class="mr-4">
                                    <div class="w-3/4">
                                            <h2 class="font-bold">{{ $product->name }}</h2>
                                        <p class="text-gray-700 break-all">
                                            {{ $product->description }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Hoogte {{ $product->height_cm }} cm
                                x Lengte {{ $product->depth_cm }} cm
                                x Breedte {{ $product->width_cm }} cm
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                &euro;{{ $product->price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('products.edit', $product) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Bewerk</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Verwijder</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                <a href="{{ route('products.create') }}"
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Voeg product toe</a>
            </div>
        @else
            <p>Geen producten gevonden</p>
        @endif
    </div>
    <div class="pagination flex justify-center items-center mt-8">
        {{ $products->appends(['search' => $search])->links('vendor.pagination.tailwind') }}
    </div>

@endsection
