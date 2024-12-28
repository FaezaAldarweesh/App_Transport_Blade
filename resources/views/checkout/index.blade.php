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
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('trip.index') }}" class="btn btn-secondary">Back</a>
                </div>

                <table class="table table-hover table-bordered">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Name Of Student</th>
                            <th>اسم الرحلة</th>
                            <th>نمط الرحلة</th>
                            <th>اسم المسار</th>
                            <th>التفقد</th>
                            <th>ملاحظات</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($checkouts as $checkout)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $checkout->student->name }}</td>
                                    <td>{{ $checkout->trip->name }}</td>
                                    <td>{{ $checkout->trip->type }}</td>
                                    <td>{{ $checkout->trip->path->name }}</td>
                                    <td>{{ $checkout->checkout == 0 ? 'غائب': 'موجود'}}</td>
                                    <td>{{ $checkout->note}}</td>
                                    <td>{{ $checkout->created_at}}</td>
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