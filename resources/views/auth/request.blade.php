@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        Request Invitation
                    </div>
                    <div class="card-body">
                        {{ $school->name }} is a closed community. You must have an initation link to register. You can request your link below.

                        <form action="{{ route('store-invitation', $school) }}" class="form-horizontal" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="col-md-4 col-form-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Request An Invitation
                                    </button>

                                    <a class="btn btn-link" href="{{ route('login') }}">Already have An Account?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
