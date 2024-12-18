<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>
<body>
    <center>
        <div>
            @if ($errors -> any())
                <div class = "contaner">
                    <ol>
                        @foreach ($errors -> all() as $error)
                            <li >{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
            @endif
        </div>
            <form action="{{ route('employee.update',$data -> id) }}" method = "POST">
                @method('PUT');
                @csrf
            <h3>Update Employee Information</h3>
            <div class = "contaner_update">
                <label>Name:</label>
                <input type="text" name = "name" value ="{{ $data -> name }}"><br><br>

                <label>Employee Job:</label>
                <input type="text" name = "em_job" value ="{{$data -> em_job }}"><br><br>

                <label>Phone:</label>
                <input type="text" name = "phone" value ="{{$data -> phone }}"><br><br>

                {{-- <label>email:</label>
                <input type="text" name = "email" value ="{{$data -> email }}"><br><br>


                <label>Age:</label>
                <input type="text" name = "age" value ="{{$data -> age }}"><br><br>

                <label>Salary:</label>
                <input type="text" name = "salary" value ="{{$data -> salary }}"><br><br> --}}
                <input type="submit" value="update Empployee">
            </div>
        </form>
    </center>
</body>
</html>