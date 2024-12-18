@extends('layouts.master')

@section('title')
الموظفون
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
@endsection

@section('content')
<body>
    <center>
        <div >
            <h2>Employee CRUD</h2>
            @if ($errors -> any())
                <div class = "contaner">
                    <ol>
                        @foreach ($errors -> all() as $error)
                            <li >{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
            @endif
            <form action="{{ route('employee.store') }}", method="POST">
                @csrf
                <input name = "name", type="text", placeholder="Name" value="{{ old("name") }}"><br><br>
                <input name = "em_job", type="text", placeholder="EmployeeJob"  value="{{ old("en_job") }}"><br><br>
                <input name = "phone", type="text", placeholder="Phone"  value="{{ old("phone") }}"><br><br>
                {{-- <input name = "email", type="text", placeholder="Email" value="{{ old("email") }}"><br><br>
                <input name = "age", type="text", placeholder="Age" value="{{ old("age") }}"><br><br>
                <input name = "salary", type="text", placeholder="Salary"  value="{{ old("salary") }}"><br><br> --}}
                <button style="margin: 10px">Create</button>
                <a class="btn btn-success" href="{{ url('employee/show') }}" style="margin: 5px">Show employees</a>
                <a href="{{ route('employee.trush') }}" style="margin: 10px">show trush</a>
            </form>
        </div>
</center>
</body>
@endsection

@section('scripts')

@endsection