@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Are you sure you want to delete <strong>{{ $user->name }}</strong>?</h2>

        <form action="{{ route('school:users.destroy', [$school, $user]) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection

