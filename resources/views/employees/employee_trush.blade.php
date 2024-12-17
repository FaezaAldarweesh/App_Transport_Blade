<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Trush</title>
</head>
<body>
    <center>
        <h3>Trush</h3>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Employee Job</th>
                <th>Phone</th>
                {{-- <th>Email</th>
                <th>Age</th>
                <th>Salary</th> --}}
                <th>Restore</th>
                <th>Delete</th>
            </tr>
            @foreach ($employee as $employee)
                <tr>
                    <td >{{$employee -> id  }}</td>
                    <td>{{$employee -> name }}</td>
                    <td>{{$employee -> em_job  }}</td>
                    <td>{{$employee -> phone  }}</td>
                    {{-- <td>{{$employee -> email  }}</td>
                    <td>{{$employee -> age  }}</td>
                    <td>{{$employee -> salary  }}</td> --}}
                    <td>
                        <form action="{{ route('employee.restor', $employee -> id) }}" method = "GET">
                            @csrf
                            <button type = "submit">Restor</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('employee.force_delete', $employee -> id) }}" method = "POST">
                            @csrf
                            @method("DELETE")
                            <button type = "submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </center>
</body>
</html>