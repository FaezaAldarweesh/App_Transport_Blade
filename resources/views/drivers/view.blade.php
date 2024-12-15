@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">{{ __('Dashboard') }}</div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong> 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <h2 class="mb-4 text-center text-secondary">Driver List</h2>

                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('driver.create') }}" class="btn btn-success text-white">
                            <i class="bi bi-plus-circle"></i> Create New Driver
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>phone</th>
                                <th>location</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($drivers as $driver)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $driver->name }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>{{ $driver->location }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('driver.edit', $driver->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('driver.destroy', $driver->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this driver?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No Driver available.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    <a href="{{ route('all_trashed_driver') }}" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Trashed Driver
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
