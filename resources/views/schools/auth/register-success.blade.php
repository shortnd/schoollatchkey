@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="alert alert-success">
                    You have been registered, please
                    @unless ($school)
                    <a href="{{ route('login') }}">login</a>
                    @else
                    <a href="{{ route('school:login', $school) }}">login</a>
                    @endunless
                    to continue.
                </div>
            </div>
        </div>
    </div>
@endsection
