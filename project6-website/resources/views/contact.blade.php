@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>

<body class="bg-green-100">
    <header class="bg-gray-900 px-5">
        <nav class="flex items-center justify-between flex-wrap">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <a href="/">
                <img src="{{ asset('images/GroeneVingersLogo.png') }}" alt="Logo" href="/" class="w-20 pr-2">
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
                    <a href="/products" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                        Producten
                    </a>
                </div>
                <div>
                    {{-- Cart --}}
                    <a href="{{ route('cart.show') }}" class="relative">
                        <span class="bg-red-500 text-white font-bold rounded-full w-6 h-6 flex items-center justify-center absolute bottom-0 right-0 transform translate-x-1/2 translate-y-1/2
                            @php
                                $cartCount = array_sum(session('cart', []));
                            @endphp
                            @if ($cartCount === 0)
                                hidden
                            @endif
                            ">
                            {{ $cartCount }}
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
                        Aanmelden
                    </a>
                    {{-- Signup --}}
                    <a href="/signup"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-4 rounded border-green-800">
                        Registreren
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
    <div id="map-container" class="flex h-screen">
        <div id="mapid" class="relative w-2/4 h-screen"></div>
        <div>
            <h1 class=" relative px-5 font-bold text-xl">Over ons: </h1>
        </div>
    </div>
    <script>
        var mymap = L.map('mapid');
        var routingControl;
        var locations = {!! json_encode($locations) !!};

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    mymap.setView([lat, lng], 12);

                    // Add user location marker
                    var userMarker = L.marker([lat, lng]).addTo(mymap);
                    userMarker.bindPopup("<b>Uw Locatie</b>").openPopup();

                    // Add markers for each location
                    var markers = [];
                    locations.forEach(function(location) {
                        var marker = L.marker([location.latitude, location.longitude]).addTo(mymap);
                        marker.bindPopup(
                            "<b>" + location.name + "</b><br>Adres: " + location.address +
                            "<br>Telefoon: " + location.Telefoon + "<br>Email: " + location.Email
                        );
                        markers.push(marker);
                    });

                    // Add marker for total number of markers
                    var marker = L.marker([lat, lng], {
                        icon: L.divIcon({
                            className: 'total-markers-icon',
                            html: '<span class="total-markers-text">' + markers.length + '</span>'
                        })
                    }).addTo(mymap);

                    // Hide markers when zoomed out
                    mymap.on('zoomend', function() {
                        if (mymap.getZoom() < 9) {
                            markers.forEach(function(marker) {
                                marker.setOpacity(0);
                                marker.options.interactive = false; // make markers unclickable
                            });
                            marker.setOpacity(1);
                            marker.bindPopup("<b>Aantal Bedrijven: " + markers.length + "</b>").openPopup();
                        } else {
                            markers.forEach(function(marker) {
                                marker.setOpacity(1);
                                marker.options.interactive = true; // make markers clickable
                            });
                            marker.setOpacity(0);
                            marker.unbindPopup();
                            console.log(mymap.getZoom());
                            if (mymap.getZoom() > 8) {
                                mymap.closePopup();
                            }
                        }
                    });


                    // Add popup for total number of markers
                    marker.bindPopup("<b>Total Markers: </b>" + markers.length);

                });
            } else {
                console.log('Geolocatie is wordt niet ondersteund door deze browser.');
            }
        }

        // Call the getLocation function to center the map on the user's location
        getLocation();

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mymap);
    </script>



</body>

</html>
@endsection
