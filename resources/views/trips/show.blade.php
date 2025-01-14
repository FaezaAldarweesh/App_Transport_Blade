@extends('layouts.master')

@section('title')
    عرض محطات المسار
@endsection

<style>
    .section-card {
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .section-header {
        color: #333;
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        background-color: #f8f9fa;
        color: #333;
    }

    .section-content {
        padding: 15px;
    }

    .back-btn {
        margin-top: 20px;
        text-align: center;
    }
</style>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header">{{ __("Trip's Details") }}</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Trip Name</th>
                                <td>{{ $trip->name }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $trip->type }}</td>
                            </tr>
                            <tr>
                                <th>Path</th>
                                <td><a href="{{ route('path.show', $trip->path->id) }}">{{ $trip->path->name }}</a></td>
                            </tr>
                            <tr>
                                <th>Bus</th>
                                <td>{{ $trip->bus->name }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $trip->status == 0 ? 'منتهية' : 'جارية' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Drivers Section -->
            <div class="section-card">
                <div class="section-header">Drivers</div>
                <div class="section-content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Driver Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trip->drivers as $index => $driver)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $driver->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Supervisors Section -->
            <div class="section-card">
                <div class="section-header">Supervisors</div>
                <div class="section-content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Supervisor Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trip->users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Students Section -->
            <div class="section-card">
                <div class="section-header">Students</div>
                <div class="section-content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Status</th>
                                <th>Time Arrived</th>
                                <th>Tool</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trip->students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->pivot->status }}</td>
                                    <td>
                                    <form action="{{ route('update_student_time_arrive', [$student->id,$trip->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="time" name="time_arrive" value="{{ $student->pivot->time_arrive }}" class="form-control" required>
                                        </td>
                                    <td class="text-center">
                                        <button type="submit" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Back Button -->
            <div class="back-btn">
                <a href="{{ route('trip.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>

