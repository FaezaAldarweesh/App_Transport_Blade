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
    .station-name {
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
        text-align:right;
        font-size: 1.50rem;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white" style="margin-top:48px">{{ __("Path's Stations Details") }}</div>
                <div class="card-body">
                    <h3><span style="color: rgba(232, 18, 18, 0.868)">Path Name:</span> {{ $path->name }}</h3>
                    @foreach ($path->stations as $station)
                        <div class="station-name">{{ $station->name }}</div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('path.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
    </div>
</div>
@endsection

//table table-bordered table-head-bg-info table-bordered-bd-info mt-4
