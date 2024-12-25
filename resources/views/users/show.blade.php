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
                       
                        
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->students as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->father_phone }}</td>
                                    <td>{{ $student->mather_phone }}</td>
                                    <td>{{ $student->longitude }}</td>
                                    <td>{{ $student->latitude }}</td>
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