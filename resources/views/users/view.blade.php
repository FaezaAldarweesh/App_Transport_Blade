@extends('layouts.master')

@section('title')
المستخدمون
@endsection

@section('css')
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<style>
    .badge-admin {
    background-color: #ffcccc;
    color: #660000;
}

.badge-parent {
    background-color: #cce5ff;
    color: #004085;
}

.badge-supervisor {
    background-color: #fff3cd;
    color: #856404;
}

.badge {
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}
</style>
@endsection

@section('content')
<div class="container" style="margin-top: 70px">
    <div class="row justify-content-center">
        {{-- <div class="col-md-10"> --}}
            <div class="card shadow-lg border-0">
                {{-- <div class="card-header bg-primary text-white">{{ __('Dashboard') }}</div> --}}

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong> 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    {{-- <h2 class="mb-4 text-center text-secondary">Driver List</h2> --}}

                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-success text-white">
                            <i class="bi bi-plus-circle"></i> Create New User
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>email</th>
                                <th>role</th>
                                <th>first phone</th>
                                <th>secound phone</th>
                                <th>location</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $role)
                                                @if ($role == 'Admin')
                                                    <label class="badge badge-admin">{{ $role }}</label>
                                                @elseif ($role == 'parent')
                                                    <label class="badge badge-parent">{{ $role }}</label>
                                                @elseif ($role == 'supervisor')
                                                    <label class="badge badge-supervisor">{{ $role }}</label>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{$user->first_phone}}</td>
                                    <td>{{$user->secound_phone}}</td>
                                    <td>{{$user->location}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                        @if($user->role == 'parent')
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        @endif
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No User available.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    {{-- <a href="{{ route('all_trashed_user') }}" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Trashed User
                    </a> --}}

                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection

@section('scripts')

@endsection