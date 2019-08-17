@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="alert alert-success">
                    You have been registered, please <a href="{{ route('login') }}">login</a> to continue.
                </div>
            </div>
        </div>
    </div>
@endsection
