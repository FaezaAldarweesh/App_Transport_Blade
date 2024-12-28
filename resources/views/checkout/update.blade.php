@extends('layouts.master')

@section('title')
تعديل بيانات الباص
@endsection

@section('css')
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container" style="margin-top:70px">
    <div class="row justify-content-center">
        <div class="card shadow-sm">
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

                <form action="{{ route('checkout.update', $checkout->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- اسم الطالب -->
                    <div class="mb-3">
                        <label for="student_name" class="form-label">اسم الطالب {{$checkout->student->name}}</label>
                        <input type="hidden" value="{{ old('student_id', $checkout->student->name) }}">
                        <input type="hidden" name="trip_id" value="{{ old('trip_id', $checkout->trip->id) }}">
                    </div>

                    <!-- الحالة -->
                    <div class="mb-3">
                        <label for="checkout" class="form-label">الحالة</label>
                        <select class="form-select @error('checkout') is-invalid @enderror" 
                                id="checkout" 
                                name="checkout" 
                                required>
                            <option value="" disabled selected>اختر الحالة</option>
                            <option value="1" {{ old('checkout', $checkout->checkout) == 1 ? 'selected' : '' }}>موجود</option>
                            <option value="0" {{ old('checkout', $checkout->checkout) == 0 ? 'selected' : '' }}>غير موجود</option>
                        </select>
                        @error('checkout')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- الملاحظات -->
                    <div class="mb-3">
                        <label for="note" class="form-label">الملاحظات</label>
                        <input type="text" class="form-control @error('note') is-invalid @enderror" 
                               id="note" 
                               name="note" 
                               value="{{ old('note', $checkout->note) }}">
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- زر التحديث -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">تحديث البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- إضافة سكريبت إذا كان مطلوبًا -->
@endsection
