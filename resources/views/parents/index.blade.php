@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($parents))
            <ul>
            @foreach ($parents as $parent)
                <li>{{ $parent->name }}</li>
            @endforeach
            </ul>
        @endif
    </div>
@endsection

