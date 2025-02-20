@extends('layouts.master')

@section('title')
الحضور و النقل
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
                                        <select class="trip-select" name="trip_id" class="form-control">
                                            <option value="">اختر رحلة جديدة</option>
                                            @foreach ($trips as $trip)
                                                <option value="{{ $trip->id }}">
                                                    {{ $trip->name }} ({{ $trip->type }}) ({{ $trip->path->name }})
                                                </option>
                                            @endforeach
                                        </select>

                                        <select class="stations-select" name="station_id" class="form-control">
                                            <option value="">اختر مكان الوقوف</option>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.trip-select').change(function () {
        var tripId = $(this).val();
        var $row = $(this).closest('tr');
        var $stationsSelect = $row.find('.stations-select');

        // الحصول على نوع الرحلة من عنصر الـ select نفسه
        var tripType = $(this).find('option:selected').text().includes('go') ? 'go' :
                       $(this).find('option:selected').text().includes('back') ? 'back' : 'غير معروف';

        console.log("نوع الرحلة المسترجع:", tripType);

        if (!tripId) {
            $stationsSelect.empty().append('<option value="">اختر مكان الوقوف</option>');
            return;
        }

        $.ajax({
            url: '/get-trip-stations/' + tripId,
            type: 'GET',
            success: function (response) {
                console.log("استجابة API:", response);

                if (!response || !response.stations) {
                    console.warn("استجابة غير صحيحة أو فارغة!");
                    $stationsSelect.empty().append('<option value="">لا توجد بيانات متاحة</option>');
                    return;
                }

                $stationsSelect.empty().append('<option value="">اختر مكان الوقوف</option>');

                if (response.stations.length > 0) {
                    response.stations.forEach(function (station) {
                        let time = "غير متاح";

                        if (tripType === 'go') {
                            time = station.time_go || "غير محدد";
                        } else if (tripType === 'back') {
                            time = station.time_back || "غير محدد";
                        } else {
                            console.warn("نوع الرحلة غير متوقع:", tripType);
                        }

                        $stationsSelect.append(
                            '<option value="' + station.id + '">' + station.name + ' (' + time + ')</option>'
                        );
                    });
                } else {
                    $stationsSelect.append('<option value="">لا توجد نقاط وقوف متاحة</option>');
                }
            },
            error: function (xhr, status, error) {
                console.error("خطأ في API:", error);
                alert('حدث خطأ أثناء تحميل نقاط الوقوف.');
            }
        });
    });
});

</script>
