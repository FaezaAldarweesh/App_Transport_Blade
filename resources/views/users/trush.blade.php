@extends('layouts.master')

@section('title')
أرشيف المستخدمين
@endsection

@section('css')
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
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
                    {{-- <h2 class="mb-4 text-center text-secondary">Trashed Driver List</h2> --}}

                    <div class="d-flex justify-content-end mb-3">
                         <a href="{{ route('user.index') }}" class="btn btn-secondary ms-2">Back</a>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                   
                                    <td class="text-center">
                                        <form action="{{ route('restore_user', $user->id) }}" method="GET" class="d-inline-block" onsubmit="return confirm('Are you sure you want to restore this user?');">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm text-white">
                                                <i class="bi bi-arrow-clockwise"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('forceDelete_user', $user->id) }}" method="POST" class="d-inline-block ms-2" onsubmit="return confirm('Are you sure you want to permanently delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Force Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No user available.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection

@section('scripts')

@endsection
