@extends('layouts.master')

@section('title')
المحطات
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

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong> 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    {{-- <h2 class="mb-4 text-center text-secondary">Station List</h2> --}}

                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('station.create') }}" class="btn btn-success text-white">
                            <i class="bi bi-plus-circle"></i> Create New Station
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>path</th>
                                <th>ٍStatus</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stations as $station)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $station->name }}</td>
                                    <td>{{ $station->path->name }}</td>
                                    @php
                                        $translation = [
                                            0 => 'لم يتم الوصول لها بعد',
                                            1 => 'تم االوصول إليها'
                                        ]   
                                    @endphp
                                    <td>
                                        <span class="badge 
                                            {{ $station->status == 0 ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $translation[$station->status] ?? $station->status }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('station.edit', $station->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('station.destroy', $station->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this station?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>

                                        <form action="{{ route('update_station_status', $station->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi {{ $station->status ? 1 : 0 }}"></i> 
                                                {{ $station->status ? 'تم الوصول إليها' : 'لم يتم الوصول إليها بعد' }}
                                            </button>
                                        </form>
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No Station available.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    {{-- <a href="{{ route('all_trashed_station') }}" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Trashed Station
                    </a> --}}

                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection

@section('scripts')

@endsection
