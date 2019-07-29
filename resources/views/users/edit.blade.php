@extends('layouts.app')

@section('content')
<div class="container">
    {{ Breadcrumbs::render('user-edit', $user) }}
    <div class="card">
        <div class="card-header">Edit {{ $user->name }}</div>
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <button type="submit" href="#" class="btn btn-success">Update</button>
                </div>
            </form>
            <fieldset>
                <legend>Current Roles</legend>
                @foreach($user->roles as $role)
                <label>
                    <input type="checkbox" name="{{ $role->name }}" checked="{{ $user->hasRole($role->name) }}" class="form-check-inline"> {{ $role->name }}
                </label>
                @endforeach
            </fieldset>
            @if($errors->any())
                @foreach($errors->all() as $error)
                  {{ $error }}
                @endforeach
            @endif
            <form action="{{ route('user.update-roles', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <fieldset>
                    <legend>Update Roles</legend>
                    @foreach ($roles as $role)
                    @role('admin')
                    <label>
                        <input type="checkbox" name="{{ $role->name }}" class="form-check-inline" {{ $user->hasRole($role->name) ? "checked" : "" }}> {{ $role->name }}
                    </label>
                    @else
                        @unless($role->name == "admin")
                        <label>
                            <input type="checkbox" name="{{ $role->name }}" class="form-check-inline" {{ $user->hasRole($role->name) ? "checked" : "" }}> {{ $role->name }}
                        </label>
                        @endunless
                    @endrole
                    <br>
                    @endforeach
                </fieldset>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-success">Update Roles</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <a href="{{ URL::previous() }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection

