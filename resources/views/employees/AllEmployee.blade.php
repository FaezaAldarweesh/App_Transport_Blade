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
        <h3>All Employee in our database</h3>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Employee Job</th>
                <th>Phone</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($employees as $employee)
            <tr>
                    <td >{{$employee -> id  }}</td>
                    <td>{{$employee -> name }}</td>
                    <td>{{$employee -> em_job  }}</td>
                    <td>{{$employee -> phone  }}</td>
                    <td><a class = "btn btn-primary" href="{{ route('employee.edit',$employee -> id) }}">edit</a></td>
                    <td><form action="{{ route('employee.destroy', $employee -> id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </center>
</body>
</html>
@endsection
@section('scripts')

@endsection