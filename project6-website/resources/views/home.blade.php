<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-hEjKDGnCxl72J1DlEk57mcKjZl6lZBb+iJ7xhqOaIbK/c/Es2QJwB/1ZNYCjKSRNNcZkClNvOorKgU0/g6UaA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-green-100">
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
                        <span class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Cart</span>
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
                    <a href="/singup"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-4 rounded border-green-800">
                        Sign Up
                    </a>
                </div>
            </div>
        </nav>
    </header>

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
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg rounded-l-lg border border-gray-200 w-32 text-center">Contact</a>
            </div>
        </div>
    </div>
    <h1 class="text-2xl font-bold text-center py-5">Products</h1>

    <div class="grid grid-cols-5 gap-4 py-5 px-5 lg:w-3/4 mx-auto">

        @foreach ($products->take(5) as $product)
            <div class="relative">
                <a href="{{ $product['image'] }}" target="_blank" class="block overflow-hidden h-max">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="object-cover w-full h-full">
                </a>
                <div class="p-4 bg-white shadow-lg rounded-lg flex flex-col justify-between">
                    <div class="mb-2">
                        <h2 class="text-lg font-bold mb-2">{{ $product['name'] }}</h2>
                    </div>
                    <div class="flex gap-4 justify-between items-center">
                        <p class="text-black font-bold text-lg">${{ $product['price'] }}</p>
                        <form method="POST" action="{{ route('cart.add') }}"
                            class="flex gap-4 items-center justify-evenly">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <input type="number" name="quantity" value="1" min="1" max="10"
                                class="w-10 outline-none">
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="flex center">
            <a href="/products"
                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg rounded-l-lg border border-green-800 w-32 text-center">Show
                more</a>
        </div>
    </div>

</body>

</html>
