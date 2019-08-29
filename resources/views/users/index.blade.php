@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('users') }}
        <div class="card">
            <div class="card-header">
                Users
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Roles</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td><a href="{{ route('school:users.show', [$school, $user]) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <div>{{ $role->name }}</div>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

