<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <!-- Include Leaflet library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Include Leaflet Routing Machine plugin -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>


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
    <div id="mapid" class="absolute left-0 w-full h-full"></div>

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
                    userMarker.bindPopup("<b>Your Location</b>").openPopup();

                    // Add markers for each location
                    var markers = [];
                    locations.forEach(function(location) {
                        var marker = L.marker([location.latitude, location.longitude]).addTo(mymap);
                        marker.bindPopup(
                            "<b>" + location.name + "</b><br>Address: " + location.address +
                            "<br>Phone: " + location.Telefoon + "<br>Email: " + location.Email
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
                console.log('Geolocation is not supported by this browser.');
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
