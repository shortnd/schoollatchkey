@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($parents))
            <ul>
            @foreach ($parents as $parent)
                <li><a href="{{ route('school:parents.show', [$school, $parent]) }}">{{ $parent->name }}</a></li>
            @endforeach
            </ul>
        @endif
    </div>
@endsection

