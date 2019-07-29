@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Create School
            </div>

            <div class="card-body">
                <form action="{{ route('schools.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name">
                    </div>

                    <div class="form-group">
                        <label for="state">State</label>
                        <select name="state" id="state" class="form-control">
                            @foreach ($states as $key=>$val)
                            <option value="{{ $key }}">{{ $key }} - {{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add School</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

