@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('schools') }}
        @if ($schools)
            <ul>
                @foreach ($schools as $school)
                    <li>
                        <a href="{{ route('school:school.index', $school) }}">{{ $school->name }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3">
                Don't see the school you are looking for <a href="{{ route('schools.create') }}">create a new one</a>.
            </div>
        @else
            <h1 class="text-center">No Schools</h1>
            <a href="{{ route('schools.create') }}">Add School</a>
        @endif
    </div>
@endsection

