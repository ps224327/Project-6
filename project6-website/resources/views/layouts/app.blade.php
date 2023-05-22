<!DOCTYPE html>
<html>

<head>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <!-- Include Leaflet library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Include Leaflet Routing Machine plugin -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
</head>

<body>
    <!-- Navbar and other common elements -->

    <div class="container mx-auto">
        @yield('content')
    </div>

    <!-- Footer and other common elements -->
</body>

</html>
