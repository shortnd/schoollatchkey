@extends('layouts.app')

@section('content')
    <div class="container">
        Name: {{ $school->name }}
        <br>
        State: {{ $school->state }}
        <br>
        slug: {{ $school->slug }}
    </div>
@endsection

