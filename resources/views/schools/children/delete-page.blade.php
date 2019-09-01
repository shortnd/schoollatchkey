@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Are you sure you want to delete {{ $child->fullName() }}</h2>
        <form action="{{ route('school:children.destory', [$school, $child]) }}" method="POST">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection
