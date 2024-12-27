{{-- @extends('layouts.master')

@section('title')
إنشاء التفقد
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
                    <a href="{{ route('checkout.index') }}" class="btn btn-secondary">Back</a>
                </div>

                <table class="table table-hover table-bordered">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Name Of Student</th>
                            <th>Status</th>
                            <th>Note</th>
                            <th>Submit</th>
                            <th>Tool</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                            @foreach ($student as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>
                                        <form action="{{ route('checkout.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                               
                                                <select class="form-select" id="checkout" name="checkout" required onchange="submitForm()">
                                                    <option value="" disabled selected>اختر الحالة</option>
                                                    <option value = 1>موجود</option>
                                                    <option value = 0>غير موجود</option>
                                                </select>
                                            </div>
                                            <td><textarea class="form-control" id="note" name="note" rows="1" placeholder="أدخل ملاحظاتك هنا..."></textarea></td>
                                            @foreach($trip as $trip)
                                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                            @endforeach
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <button type="submit" class="btn btn-success" style="margin-top:5px">تسجيل</button>
                                                </div>
                                            </td>
                                        </form>
                                    </td>
                                    <td></td>
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
@endsection --}}
@extends('layouts.master')

@section('title', 'إنشاء التفقد')

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
                    <a href="{{ route('checkout.index') }}" class="btn btn-secondary">Back</a>
                </div>

                <table class="table table-hover table-bordered">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Name Of Student</th>
                            <th>Status</th>
                            <th>Note</th>
                            <th>Submit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student as $student)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $student->name }}</td>
                                <td>
                                    <form action="{{ route('checkout.store') }}" method="POST" id="attendanceForm{{ $student->id }}">
                                        @csrf
                                        <div class="mb-3">
                                            <select class="form-select" id="checkout" name="student_presence" required onchange="submitForm({{ $student->id }})">
                                                <option value="" disabled selected>اختر الحالة</option>
                                                <option value="present">موجود</option>
                                                <option value="absent">غير موجود</option>
                                            </select>
                                        </div>
                                        
                                        {{-- <input type="hidden" name="trip_id" value="{{ $trip->id }}"> --}}
                                        
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                </td>
                                <td>
                                    <textarea class="form-control" id="note" name="note" rows="1" placeholder="أدخل ملاحظاتك هنا..."></textarea>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success" style="margin-top:5px">تسجيل</button>
                                </td>
                                    </form>
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
        function submitForm(studentId) {
            document.getElementById('attendanceForm' + studentId).submit();
        }
    </script>
@endsection
