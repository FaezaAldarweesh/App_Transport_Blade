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
                <div class="d-flex justify-content-between mb-3">
                    @can('show checkout')
                    <a href="{{ route('show_checkout',$trip->id) }}" class="btn btn-success text-white">
                        <i class="bi bi-plus-circle"></i> show checkout
                    </a>
                    @endcan
                    <a href="{{ route('trip.index',$trip->id) }}" class="btn btn-secondary">Back</a>
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
                        @foreach ($trip->students as $student)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $student->name }}</td>
                                <td>
                                    @can('add checkout')
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
                                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <button type="submit" class="btn btn-success" style="margin-top:5px">تسجيل</button>
                                            </div>
                                        </td>
                                    </form>
                                    @endcan
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