@extends('layouts.app')

@section('content')

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

@endsection
