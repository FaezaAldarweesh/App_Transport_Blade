@extends('layouts.master')

@section('title')
الرحلات
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
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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

                <div class="card-body">
                    {{-- <h2 class="mb-4 text-center text-secondary">Trip List</h2> --}}

                    <div class="d-flex justify-content-between mb-3">                        
                        <a href="{{ route('trip.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>status</th>
                                <th>غياب/حضور</th>
                                <th>الرحل</th>
                                <th>نقل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Trip->students as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td> 
                                    @php
                                        $translations = [
                                            'attendee' => 'موجود',
                                            'absent' => 'غائب',
                                            'Moved_to' => 'مَنقول',
                                            'Transferred_from' => 'نُقل',
                                        ];  
                                    @endphp
                                    <td>
                                        <span class="badge 
                                            {{ $student->pivot->status == 'attendee' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $translations[$student->pivot->status] ?? $student->pivot->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                    @can('update student status')
                                    <form action="{{ route('update_student_status', [$student->pivot->student_id,$student->pivot->trip_id]) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> تحديث الحالة
                                        </button>
                                    </form>
                                    @endcan

                                    <td>
                                    @can('update student status transport')
                                    <form action="{{ route('update_student_status_transport',$student->id) }}" method="POST" class="d-inline-block">
                                    @csrf    
                                        <select name="trip_id" class="form-control">
                                            <option value="">اختر رحلة جديدة</option>
                                            @foreach ($trips as $trip)
                                            <option value="{{ $trip->id }}">
                                                    {{ $trip->name }} ({{ $trip->type }}) ({{ $trip->path->name }})
                                                </option>
                                            @endforeach
                                        </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-arrow-right"></i> نقل
                                            </button>
                                        </td>
                                    </form>
                                    @endcan
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
    </div>
</div>
@endsection
