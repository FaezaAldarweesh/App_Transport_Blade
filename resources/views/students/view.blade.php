@extends('layouts.master')

@section('title')
الطلاب
@endsection

@section('css')
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="container" style="margin-top: 70px">
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
                    {{-- <h2 class="mb-4 text-center text-secondary">Student List</h2> --}}

                    <div class="d-flex justify-content-between mb-3">
                        @can('add trip')
                        <a href="{{ route('add student') }}" class="btn btn-success text-white">
                            <i class="bi bi-plus-circle"></i> Create New Student
                        </a>
                        @endcan
                        
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
                                    <td class="text-center">
                                        @can('update student')
                                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        @endcan
                                        @can('destroy student')
                                        <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                        @endcan

                                        @can('show student trip')
                                        <a href="{{ route('student.show', $student->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        @endcan

                                        @can('show student checkout')
                                        <a href="{{ route('checkout.index') }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> CheckOut
                                        </a>
                                        @endcan
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No students available.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    {{-- <a href="{{ route('all_trashed_student') }}" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Trashed Student
                    </a> --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
@endsection