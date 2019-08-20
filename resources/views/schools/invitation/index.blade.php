@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Invitation Requests</h1>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Pending Requested <span class="badge">{{ count($invitations) }}</span>
            </div>
            <div class="card-body">
                @unless (count($invitations) > 0)
                    <p>No invitations requested!</p>
                @else
                    <table class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Requested On</th>
                                <th>Invitation Link</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invitations as $invitation)
                                <tr>
                                    <td>
                                        <a href="mailto:{{ $invitation->email }}">{{ $invitation->email }}</a>
                                    </td>
                                    <td>
                                        {{ $invitation->created_at->format("m/d/Y") }}
                                    </td>
                                    <td>
                                        <kbd>{{ $invitation->getLink() }}</kbd>
                                    </td>
                                    <td>
                                        <form action="{{ route("school:delete-invitation", [$school, $invitation]) }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endunless
            </div>
        </div>
    </div>
@endsection

