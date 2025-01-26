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
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        .controls {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('content')

    <div class="controls">
        <form id="search-form" method="GET" action="{{ url('/trip-tracks/'.$trip) }}">
            <input type="date" id="trip-date" name="trip_date">
            <input type="submit" value="Search">
        </form>
    </div>

    <div id="map"></div>

    <script>
        const mapConfig = {
            elementId: 'map',
            center: [35.1318, 36.7578],
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

        const parseLocation = (locationString) => {
            const match = locationString.match(/(-?\d+)°(\d+)'([\d.]+)"([NSEW])/);
            if (!match) return null;

            let [_, degrees, minutes, seconds, direction] = match.map(parseFloat);
            let decimal = degrees + minutes / 60 + seconds / 3600;

            return (direction === "S" || direction === "W") ? -decimal : decimal;
        };

        const fetchBusLocations = async (url) => {
            try {
                const response = await fetch(url);
                const data = await response.json();

                if (polyline) map.removeLayer(polyline);

                const coordinates = data.map(item => {
                    const [latStr, lngStr] = item.location.split(" ");
                    const lat = parseLocation(latStr);
                    const lng = parseLocation(lngStr);
                    return lat !== null && lng !== null ? [lat, lng] : null;
                }).filter(Boolean);

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
                }, 30000);
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
@endsection
