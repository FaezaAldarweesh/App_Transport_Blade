@extends('layouts.master')

@section('title')
تعديل الرحلة
@endsection

@section('css')
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-8"> --}}
            <div class="card shadow-sm">
                {{-- <div class="card-header">{{ __('Edit Trip') }}</div> --}}

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('trip.update', $trip->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <select id="name" name="name" class="form-control" required>
                                <option value="" disabled>Select name</option>
                                <option value="delivery" {{ $trip->name === 'delivery' ? 'selected' : '' }}>توصيل</option>
                                <option value="school" {{ $trip->name === 'school' ? 'selected' : '' }}>مدرسية</option>
                            </select>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type">Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="" disabled>Select type</option>
                                <option value="go" {{ $trip->name === 'go' ? 'selected' : '' }}>ذهاب</option>
                                <option value="back" {{ $trip->name === 'back' ? 'selected' : '' }}>عودة</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Path Field -->
                        <div class="mb-3">
                            <label for="path_id">Path</label>
                            <select id="path_id" name="path_id" class="form-control" required>
                                <option value="" disabled>Select Path</option>
                                @foreach($paths as $path)
                                    <option value="{{ $path->id }}" {{ $trip->path_id == $path->id ? 'selected' : '' }}>{{ $path->name }}</option>
                                @endforeach
                            </select>
                            @error('path_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bus Field -->
                        <div class="mb-3">
                            <label for="bus_id">Bus</label>
                            <select id="bus_id" name="bus_id" class="form-control" required>
                                <option value="" disabled>Select Bus</option>
                                @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}" {{ $trip->bus_id == $bus->id ? 'selected' : '' }}>{{ $bus->name }}</option>
                                @endforeach
                            </select>
                            @error('bus_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="level">level</label>
                            <select id="level" name="level" class="form-control" required>
                                <option value="" disabled >Select level</option>
                                <option value="primary" {{ $trip->name === 'primary' ? 'selected' : '' }}>ابتدائي</option>
                                <option value="mid" {{ $trip->name === 'mid' ? 'selected' : '' }}>إعدادي</option>
                                <option value="secoundary" {{ $trip->name === 'secoundary' ? 'selected' : '' }}>ثانوي</option>
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">start time</label>
                            <input type="time" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $trip->start_date) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">end time</label>
                            <input type="time" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $trip->end_date) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Students Field -->
                        <div class="mb-3">
                            <label for="students">Students</label>
                            <select id="students" name="students[]" class="form-control select2" multiple="multiple" required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ in_array($student->id, $trip->students->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('students')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                         <!-- Supervisors Field -->
                         <div class="mb-3">
                            <label for="supervisors">Supervisors</label>
                            <select id="supervisors" name="supervisors[]" class="form-control select2" multiple="multiple" required>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}" {{ in_array($supervisor->id, $trip->users->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $supervisor->name }}</option>
                                @endforeach
                            </select>
                            @error('supervisors')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Drivers Field -->
                        <div class="mb-3">
                            <label for="drivers">Drivers</label>
                            <select id="drivers" name="drivers[]" class="form-control select2" multiple="multiple" required>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ in_array($driver->id, $trip->drivers->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $driver->name }}</option>
                                @endforeach
                            </select>
                            @error('drivers')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Update Trip</button>
                            <a href="{{ route('trip.index') }}" class="btn btn-secondary ms-2">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection

@section('scripts')
<!-- Add Select2 CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Students",
            allowClear: true
        });
    });
</script>
@endsection
