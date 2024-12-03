@extends('user::layouts.master')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">User Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Firma: {{ $user->firma }}</h5>
                <p class="card-text"><strong>Name:</strong> {{ $user->name }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>

                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
