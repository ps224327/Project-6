<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet"
        href="//cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />
    <!-- Leaflet Routing Machine JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js"></script>
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
                    <a href="{{ route('cart.show') }}"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Cart
                        ({{ count(session('cart', [])) }})</a>
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">
                            <p class="font-bold">{{ session('success') }}</p>
                        </div>
                    @endif
                    <a href="/login"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-4 rounded border-green-800">
                        Log In
                    </a>
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
                <a href="/"
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg rounded-l-lg border border-gray-200 w-32 text-center">Home</a>
            </div>
        </div>
    </div>
    <div id="mapid" class="absolute bottom-0 left-0 w-1/2" style="height: 500px"></div>

    <script>
        var mymap = L.map('mapid');
        var routingControl;

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    mymap.setView([lat, lng], 12);

                    @foreach ($locations->take(3) as $location)
                        // Add routing control
                        routingControl = L.Routing.control({
                            waypoints: [
                                L.latLng(lat, lng),
                                L.latLng({{ $location->latitude }}, {{ $location->longitude }})
                            ],
                            routeWhileDragging: true,
                            geocoder: L.Control.Geocoder.nominatim(),
                            router: L.Routing.osrmv1({
                                serviceUrl: 'https://router.project-osrm.org/route/v1'
                            })
                        }).addTo(mymap);
                    @endforeach
                });
            } else {
                console.log('Geolocation is not supported by this browser.');
            }
        }

        // Call the getLocation function to center the map on the user's location and add routing control
        getLocation();

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mymap);

        @foreach ($locations->take(3) as $location)
            L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).addTo(mymap)
                .bindPopup("<b>{{ $location->name }}</b><br>{{ $location->address }}");
        @endforeach
    </script>


    <style>
        .leaflet-routing-container-hide {
            display: none;
        }

        .leaflet-routing-container {
            background-color: #fff;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 1px 7px rgba(0, 0, 0, 0.65);
        }
    </style>

</body>

</html>
