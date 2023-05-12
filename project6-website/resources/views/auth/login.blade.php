<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">

    <title>Login</title>
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
    @extends('layouts.app')

    @section('content')
        <div class="flex justify-center items-center h-screen">
            <form action="{{ route('login') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Email" name="email">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Wachtwoord
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" placeholder="********" name="password">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Log In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-green-700 hover:text-green-600"
                        href="#">
                        Wachtwoord vergeten?
                    </a>
                </div>
            </form>
        </div>
    @endsection

</body>

</html>
