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
                    <h2 class="mb-4 text-center text-secondary">Student List</h2>

                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('student.create') }}" class="btn btn-success text-white">
                            <i class="bi bi-plus-circle"></i> Create New Student
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>father_phone</th>
                                <th>mather_phone</th>
                                <th>longitude</th>
                                <th>latitude</th>
                                <th>parent</th>
                                <th>status</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->father_phone }}</td>
                                    <td>{{ $student->mather_phone }}</td>
                                    <td>{{ $student->longitude }}</td>
                                    <td>{{ $student->latitude }}</td>
                                    <td>{{ $student->user->name }}</td>
                                    @php
                                        $translations = [
                                            'attendee' => 'موجود',
                                            'absent_all' => 'غائب تمامًا',
                                            'absent_go' => 'غائب عن الذهاب',
                                            'absent_back' => 'غائب عن العودة',
                                            'transported' => 'تم نقله',
                                        ];
                                    @endphp

                                    <td>
                                        <span class="badge 
                                            {{ $student->status == 'attendee' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $translations[$student->status] ?? $student->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No students available.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    <a href="{{ route('all_trashed_student') }}" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Trashed Student
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
