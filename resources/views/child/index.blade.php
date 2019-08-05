@extends('layouts.app')

@section('content')
    <div class="container">
        @forelse ($children as $child)
            <div>
                <a href="{{ route('school:children.show', [$school, $child]) }}">{{ $child->first_name }}</a>
            </div>
        @empty
            <h2 class="h4 text-center">No Children in this school</h2>
            <a href="{{ route('school:children.create', $school) }}">Add Children</a>
        @endforelse
    </div>
@endsection
