@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <header class="card-header">
                Add Child
            </header>
            @livewire('children.create-form', $school)
            {{-- <form action="{{ route('school:children.store', $school) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input
                            type="text"
                            name="first_name"
                            id="first_name"
                            class="form-control @error('first_name')is-invalid @enderror" required>
                        @error ('first_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            class="form-control @error('last_name')is-invalid @enderror" required>
                        @error ('last_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Child</button>
                    </div>
                </div>
            </form> --}}
        </div>
    </div>
@endsection

