@extends('layouts.app')

@section('content')
    <div class="container">
        @forelse ($children as $child)
        <div>
            <a href="{{ route('school:children.show', [$school, $child]) }}">{{ $child->fullName() }}</a>
        </div>
        @empty
            <h2>No Children</h2>
            <a href="{{ route('school:children.create', [$school]) }}">Add Child</a>
        @endforelse
    </div>
@endsection

