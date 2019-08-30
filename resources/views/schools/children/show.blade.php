@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">{{ $child->fullName() }}</h2>

        <a href="{{ route('school:children.edit', [$school, $child]) }}" class="btn btn-success">Edit</a>
        <a href="{{ route('school:children.delete-page', [$school, $child]) }}" class="btn btn-danger">Delete</a>

        @if ($today_checkin)
        <div class="card">
            <div class="card-header">
                Current Day Checkin - {{ $today_checkin->created_at->format('M d') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>
                            Am Checkin
                        </th>
                        <th>
                            Pm Checkin
                        </th>
                        <th>
                            Pm Checkout
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ $today_checkin->am_checkin }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <h2>No Checkins for today</h2>
        @endif

        @if ($child->emergency_contact_name)
        <div class="card">
            <div class="card-header">
                Emergency Contact Info
            </div>
            <div class="card-body">
                <h3>Contact Name: {{ $child->emergency_contact_name }}</h3>
                <h4>Contact Number: {{ $child->emergency_contact_number }}</h4>
                <h4>Contact Relationship: {{ $child->emergency_contact_relationship }}</h4>
            </div>
        </div>
        @endif

        @if ($child->childParent)
            @foreach ($child->childParent as $parent)
                <div class="card">
                    <div class="card-header">
                        {{ $parent->name }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

