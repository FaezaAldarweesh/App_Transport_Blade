@extends('layouts.master')

@section('title')
الرحلات
@endsection

@section('css')

@endsection

@section('content')
<div class="container" style="margin-top: 70px">
    <div class="row justify-content-center">
        <div class="card shadow-lg border-0">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('driver.index') }}" class="btn btn-secondary">Back</a>
                </div>

                <table class="table table-hover table-bordered">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Name of Trip</th>
                            <th>Type</th>
                            <th>Path </th>
                            <th>Bus</th>
                            <th>Status</th>
                            <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($driver_trip as $trip)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $trip->name}}</td>
                                <td>{{ $trip->type}}</td>
                                <td><a href="{{ route('path.show', $trip->path->id) }}">{{ $trip->path->name}}</a></td>
                                <td>{{ $trip->bus->name}}</td>
                                <td>{{ $trip->status == 0 ? 'منتهية': 'جارية'}}</td> 
                                <td>
                                    <a href="{{ route('trip.show', $trip->id) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function submitForm() {
            document.getElementById('attendanceForm').submit();
        }
    </script>
@endsection