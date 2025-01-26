@extends('layouts.master')

@section('map-head')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

@endsection

@section('css')
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
    <style>
        #map {
            height: 700px;
            width: 95%;
        }

        .card-body {
            text-align: center;
        }

    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div>
                        <form class="controls" id="search-form" method="GET" action="{{ url('/trip-tracks/'.$trip) }}">
                            <input type="date" id="trip-date" name="trip_date">
                            <input type="submit" value="Search">
                        </form>
                    </div>
                    <div>
                        <div id="map" class="mx-auto my-4"></div>
                    </div>


                    <script>
                        const mapConfig = {
                            elementId: 'map',
                            center: [35.1318, 36.7578], // مركز افتراضي
                            zoom: 13,
                            tileLayerUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                            tileLayerOptions: {
                                maxZoom: 19,
                                attribution: '© OpenStreetMap contributors'
                            },
                            apiUrl: `/trip-tracks/{{$trip}}`
                        };

                        const map = L.map(mapConfig.elementId).setView(mapConfig.center, mapConfig.zoom);
                        L.tileLayer(mapConfig.tileLayerUrl, mapConfig.tileLayerOptions).addTo(map);

                        let polyline = null;
                        let autoUpdateInterval = null;

                        const fetchBusLocations = async (url) => {
                            try {
                                const response = await fetch(url);
                                const data = await response.json();

                                if (polyline) map.removeLayer(polyline);

                                // استخراج الإحداثيات من البيانات
                                const coordinates = data.map(item => {
                                    const lat = parseFloat(item.latitude);
                                    const lng = parseFloat(item.longitude);
                                    return [lat, lng];
                                });

                                if (coordinates.length > 1) {
                                    polyline = L.polyline(coordinates, {color: 'red', weight: 3}).addTo(map);
                                    map.fitBounds(polyline.getBounds());
                                }
                            } catch (error) {
                                console.error("Failed to fetch bus locations:", error);
                            }
                        };

                        const startAutoUpdate = () => {
                            if (!autoUpdateInterval) {
                                autoUpdateInterval = setInterval(() => {
                                    fetchBusLocations(mapConfig.apiUrl);
                                }, 30000); // كل 30 ثانية
                            }
                        };

                        const stopAutoUpdate = () => {
                            if (autoUpdateInterval) {
                                clearInterval(autoUpdateInterval);
                                autoUpdateInterval = null;
                            }
                        };

                        document.getElementById('search-form').addEventListener('submit', (event) => {
                            event.preventDefault();

                            const dateInput = document.getElementById('trip-date').value;
                            if (dateInput) {
                                stopAutoUpdate();
                                const apiUrlWithDate = `${mapConfig.apiUrl}?trip_date=${dateInput}`;
                                fetchBusLocations(apiUrlWithDate);
                            } else {
                                startAutoUpdate();
                            }
                        });

                        startAutoUpdate();
                        fetchBusLocations(mapConfig.apiUrl);
                    </script>
                </div>
            </div>
        </div>
    </div>

@endsection
