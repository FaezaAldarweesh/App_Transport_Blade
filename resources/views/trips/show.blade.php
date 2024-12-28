@extends('layouts.master')

@section('title')
عرض محطات المسار
@endsection

@section('css')
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<style>
    .card-header {
        text-align: center;
        font-weight: bold;
    }
    h3 {
        margin-bottom: 20px;
        font-size: 1.75rem;
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
        text-transform: uppercase;
        text-align: center;
    }
    .style1 {
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
        text-align:right;
        font-size: 1.50rem;
    }
    .style2{
        color:#116dabd0
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white" style="margin-top:48px">{{ __("Trips's Details") }}</div>
                <div class="card-body">
                    <h3><span style="color: rgba(232, 18, 18, 0.868)">Trip Name:</span> {{ $trip->name }}</h3>
                    {{-- <div class="style1"> --}}
                        <p class="style1"><span class="style2">type:</span> {{ $trip->type }}</p>
                        <a href="{{ route('path.show', $trip->path->id) }}"><p class="style1"><span class="style2">path: </span>{{ $trip->path->name }}</p></a>
                        <p class="style1"><span class="style2">bus: </span>{{ $trip->bus->name }}</p>
                        <p class="style1"><span class="style2">status:</span> {{ $trip->status == 0 ? 'منتهية' : 'جارية'}}</p>
                        @foreach($trip->drivers as $driver)
                        <p class="style1"><span class="style2">drivers:</span> {{ $driver->name}}</p>
                        @endforeach

                        @foreach($trip->users as $user)
                            <p class="style1"><span class="style2">supervisor:</span> {{ $user->name}}</p>
                        @endforeach

                        @foreach($trip->students as $student)
                            <p class="style1"><span class="style2">students:</span> {{ $student->name}}</p>
                        @endforeach

                    {{-- </div> --}}
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('trip.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
    </div>
</div>
@endsection
