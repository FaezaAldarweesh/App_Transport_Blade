@extends('layouts.master')

@section('title')
أرشيف الطلاب
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
                        <strong>{{ session('success') }}</strong> <!-- يمكنك إضافة رمز لزيادة الجاذبية -->
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    {{-- <h2 class="mb-4 text-center text-secondary">Trashed Students List</h2> --}}

                    <div class="d-flex justify-content-end mb-3">
                         <a href="{{ route('student.index') }}" class="btn btn-secondary ms-2">Back</a>
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
                                    @foreach ($users as $user)  
                                        <td>{{ $student->user->name }}</td>
                                    @endforeach
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
                                        <form action="{{ route('restore_student', $student->id) }}" method="GET" class="d-inline-block" onsubmit="return confirm('Are you sure you want to restore this student?');">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm text-white">
                                                <i class="bi bi-arrow-clockwise"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('forceDelete_student', $student->id) }}" method="POST" class="d-inline-block ms-2" onsubmit="return confirm('Are you sure you want to permanently delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Force Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No students available.</td>
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
