@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('school:children.search-checkins', [$school, $child]) }}" method="get">
            @csrf
            <div class="form-group row">
                <label for="start_date" class="col-md-4 col-form-label text-right">Start Date</label>
                <div class="col-md-6">
                    <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="end_date" class="col-md-4 col-form-label text-right">End Date</label>
                <div class="col-md-6">
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </div>
        </form>

        @if ($checkins)
            @foreach($checkins as $checkin)
            <div class="card">
                <div class="card-header">
                    {{ $checkin->created_at->format('M d') }}
                </div>
                <div class="card-body">
                    {{-- TODO: IMPLEMENT TABLE HERE AGAIN --}}
                </div>
            </div>
            @endforeach
        @endif
    </div>
@endsection

