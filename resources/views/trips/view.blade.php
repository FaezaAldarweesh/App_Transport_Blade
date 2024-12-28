@extends('layouts.master')

@section('title')
الرحلات
@endsection

@section('css')
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-10"> --}}
            <div class="card shadow-lg border-0">
                {{-- <div class="card-header bg-primary text-white">{{ __('Dashboard') }}</div> --}}
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong> 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    {{-- <h2 class="mb-4 text-center text-secondary">Trip List</h2> --}}

                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('trip.create') }}" class="btn btn-success text-white">
                            <i class="bi bi-plus-circle"></i> Create New Trip
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>type</th>
                                <th>path</th>
                                <th>bus</th>
                                <th>status</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trips as $trip)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $trip->name }}</td>
                                    <td>{{ $trip->type }}</td>
                                    <td>{{ $trip->path->name }}</td>
                                    <td>{{ $trip->bus->name }}</td>
                                    @php
                                        $translations = [
                                            0 => 'منتهية',
                                            1 => 'جارية',
                                        ];
                                    @endphp

                                    <td>
                                        <span class="badge 
                                            {{ $trip->status == 0 ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $translations[$trip->status] ?? $trip->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('trip.edit', $trip->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('trip.destroy', $trip->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this trip?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>

                                        <a href="{{ route('trip.show', $trip->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>

                                        <form action="{{ route('update_trip_status', $trip->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi {{ $trip->status ? 1 : 0 }}"></i> 
                                                {{ $trip->status ? 'جارية' : 'منتهية' }}
                                            </button>
                                        </form>
                                        <a href="{{ route('checkout.show',$trip->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> CheckOut
                                        </a>
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No trips available.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
@endsection
