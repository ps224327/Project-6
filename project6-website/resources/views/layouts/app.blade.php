<!DOCTYPE html>
<html>

<head>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <!-- Include Leaflet library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Include Leaflet Routing Machine plugin -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <!-- Include the alert box -->
    @include('_alert', ['alert' => session('alert')])

    <!-- Navbar -->
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
                    <a href="/producten" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                        Producten
                    </a>
                </div>
                <div>
                    {{-- Login / Signup --}}
                    @if (Auth::check())
                        @if (Gate::allows('webEmployee') || Gate::allows('webAdmin'))
                            <!-- Display elements for webEmployee & webAdmin roles -->
                            @if (Gate::allows('webAdmin'))
                                <a href="{{ route('products.index') }}" class="relative">
                                    <span
                                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-2 rounded border-green-800">
                                        Product Dashboard
                                    </span>
                                </a>
                            @endif
                            @if (Gate::allows('webAdmin'))
                                <a href="{{ route('employees.index') }}" class="relative pl-2">
                                    <span
                                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-2 rounded border-green-800">
                                        Medewerker Dashboard
                                    </span>
                                </a>
                            @endif
                        @endif

                        <a href="{{ route('profile') }}" class="relative pl-2">
                            <span
                                class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-2 rounded border-green-800">
                                Profiel
                            </span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline relative pl-2">
                            @csrf
                            <button
                                class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-2 rounded border-green-800">
                                Uitloggen
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="relative">
                            <span
                                class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-2 rounded border-green-800">
                                Aanmelden
                            </span>
                        </a>
                        <a href="{{ route('signup') }}" class="relative pl-2">
                            <span
                                class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-2 rounded border-green-800">
                                Registreren
                            </span>
                        </a>
                    @endif

                    {{-- Cart --}}
                    <a href="{{ route('cart.show') }}" class="relative pl-5">
                        @auth
                            @php
                                $cartCount = Auth::user()
                                    ->carts()
                                    ->sum('quantity');
                            @endphp
                            @if ($cartCount > 0)
                                <span
                                    class="bg-red-500 text-white font-bold rounded-full w-6 h-6 flex items-center justify-center absolute bottom-0 right-0 transform translate-x-1/2 translate-y-1/2">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        @endauth

                        <span class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-shopping-cart"></i>
                        </span>
                    </a>


                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    <div class="container mx-auto">
        @yield('content')
    </div>

    <!-- Footer and other common elements -->
</body>

</html>
