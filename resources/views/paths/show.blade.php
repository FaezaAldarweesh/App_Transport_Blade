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

                <div class="card-body">
                    {{-- <h2 class="mb-4 text-center text-secondary">Station List</h2> --}}
                    @if (session('custom_error'))
                        <div class="alert alert-danger">
                            {{ session('custom_error') }}
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

                    <div class="d-flex justify-content-between mb-3">
                        
                        <a href="{{ route('path.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>ٍStatus</th>
                                @can('update station status')
                                <th>tool</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($path->stations as $station)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $station->name }}</td>
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
                                    @can('update station status')
                                    <form action="{{ route('update_station_status', $station->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi {{ $station->status ? 1 : 0 }}"></i> 
                                            {{ $station->status ? 'تم الوصول إليها' : 'لم يتم الوصول إليها بعد' }}
                                        </button>
                                    </form>
                                    @endcan
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
