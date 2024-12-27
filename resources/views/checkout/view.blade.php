 @extends('layouts.master')

@section('title')
التفقد
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
                    <a href="{{ route('checkout.index') }}" class="btn btn-success text-white">
                        <i class="bi bi-plus-circle"></i> show checkout
                    </a>
                    <a href="{{ route('trip.index') }}" class="btn btn-secondary">Back</a>
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
                        {{-- @foreach($trip as $trip) --}}
                            @foreach ($trip->students as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>
                                        <form action="{{ route('checkout.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                {{-- <label for="student_presence" class="form-label">حالة الطالب</label> --}}
                                                {{-- <select class="form-select" id="student_presence" name="student_presence"  required> --}}
                                                <select class="form-select" id="checkout" name="checkout" required onchange="submitForm()">
                                                    <option value="" disabled selected>اختر الحالة</option>
                                                    <option value = 1>موجود</option>
                                                    <option value = 0>غير موجود</option>
                                                </select>
                                            </div>
                                            <td><textarea class="form-control" id="note" name="note" rows="1" placeholder="أدخل ملاحظاتك هنا..."></textarea></td>
                                            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
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
                        {{-- @endforeach --}}
                        {{-- @if($checkouts->isEmpty())
                            <tr>
                                <td colspan="2" class="text-center text-muted">No checkouts available.</td>
                            </tr>
                        @endif --}}
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