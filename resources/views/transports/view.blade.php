@extends('layouts.master')

@section('title')
طلبات النقل
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
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>student name</th>
                                <th>trip name</th>
                                <th>trip type</th>
                                <th>trip path</th>
                                <th>trip bus</th>
                                <th>station</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transports as $transport)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $transport->student->name }}</td>
                                    <td>{{ $transport->trip->name }}</td>
                                    <td>{{ $transport->trip->type }}</td>
                                    <td>{{ $transport->trip->path->name }}</td>
                                    <td>{{ $transport->trip->bus->name }}</td>
                                    <td>{{ $transport->station->name }}</td>
                                    <td class="text-center">

                                        <form action="{{ route('accept_student_transport', $transport->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm text-white">
                                                <i class="bi bi-trash"></i> Accept
                                            </button>
                                        </form>

                                        <form action="{{ route('destroy_transport', $transport->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this transport?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
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
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection

@section('scripts')

@endsection
