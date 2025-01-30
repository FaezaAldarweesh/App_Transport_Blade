@extends('layouts.master')

@section('title')
تعديل المحطة
@endsection
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
            height: 500px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
<script>
        document.addEventListener("DOMContentLoaded", () => {
            const map = L.map('map').setView([35.1318, 36.7578], 13);

            // Add map tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let marker; // For storing the current marker

            // Handle map click event
            map.on('click', (e) => {
                const {lat, lng} = e.latlng;

                // Remove existing marker
                if (marker) marker.remove();

                // Add new marker
                marker = L.marker([lat, lng]).addTo(map);

                // Update hidden inputs with latitude and longitude
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                // Optionally, show the coordinates in a readable format
                document.getElementById('location').value = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            });
        });
    </script>
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-8"> --}}
            <div class="card shadow-sm">
                {{-- <div class="card-header">{{ __('Edit station') }}</div> --}}

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('station.update', $station->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        
                        <div class="mb-3">
                            <div id="map" style="height: 400px;"></div>
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                   id="latitude" name="latitude" value="{{ old('latitude', $station->latitude) }}" readonly>
                            @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                   id="longitude" name="longitude" value="{{ old('longitude', $station->longitude) }}" readonly>
                            @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $station->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1">path</label>
                            <select id="path_id" name="path_id" class="form-control" required>
                                <option value="" disabled {{ old('path_id', $station->path_id) ? '' : 'selected' }}>Select path</option>
                                @foreach($paths as $path)
                                    <option value="{{ $path->id }}" 
                                        {{ old('path_id', $station->path_id) == $path->id ? 'selected' : '' }}>
                                        {{ $path->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('path_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="time_go" class="form-label">time go</label>
                            <input type="time" class="form-control @error('time_go') is-invalid @enderror" id="time_go" name="time_go" value="{{ old('time_go', $station->time_go) }}">
                            @error('time_go')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="time_back" class="form-label">time back</label>
                            <input type="time" class="form-control @error('time_back') is-invalid @enderror" id="time_back" name="time_back" value="{{ old('time_back', $station->time_back) }}">
                            @error('time_back')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value=0 {{ old('status', $station->status) == 0 ? 'selected' : '' }}>لم يتم الوصول لها بعد</option>
                                <option value=1 {{ old('status', $station->status) == 1 ? 'selected' : '' }}>تم االوصول إليها</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Update Station</button>
                            <a href="{{ route('station.index') }}" class="btn btn-secondary ms-2">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection

@section('scripts')

@endsection