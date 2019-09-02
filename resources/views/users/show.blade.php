@extends('layouts.app')

@section('content')
<div class="container">
    {{-- {{ Breadcrumbs::render('user', $user) }} --}}
    <div class="card">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            <h2 class="h6">Email: {{ $user->email }}</h2>
        </div>
        <div class="card-footer">
            <a href="{{ route('school:users.edit', [$school, $user]) }}" class="btn btn-success">Edit</a> <a href="{{ route('school:users.delete-confirm', [$school, $user]) }}" class="btn btn-danger">Delete</a>
        </div>
    </div>
</div>
@endsection

