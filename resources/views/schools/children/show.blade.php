@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">{{ $child->fullName() }}</h2>

        <a href="{{ route('school:children.edit', [$school, $child]) }}" class="btn btn-success">Edit</a>
        <a href="{{ route('school:children.delete-page', [$school, $child]) }}" class="btn btn-danger">Delete</a>

        @if ($today_checkin)
        <div class="card mt-3">
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
                                {{
                                    $today_checkin->am_checkin
                                    ? $today_checkin->am_checkin_time
                                    : "Not Checked in today"
                                }}
                            </td>
                            <td>
                                {{
                                    $today_checkin->pm_checkin
                                    ? $today_checkin->pm_checkin_time
                                    : "Not Checked in today"
                                }}
                            </td>
                            <td>
                                @if (!$today_checkin->pm_checkin)
                                <strong>Student not checked in today</strong>
                                @else
                                    {{
                                        $today_checkin->pm_checkout
                                        ? Carbon\Carbon::diffForHumans($today_checkin->pm_checkout_time)
                                        : "Not Checked out yet"
                                    }}
                                @endif
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

        <div class="card mt-3">
            <div class="card-header">
                Current week of - {{ startOfWeek()->format('M d') }}
            </div>
            <div class="card-body">
                @foreach ($week_checkin as $checkin)
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2">{{ $checkin->created_at->format('D') }}</th>
                            <th class="text-right">
                                <a href="{{ route('school:children.checkin', [$school, $child, $checkin]) }}">Details</a>
                            </th>
                        </tr>
                        <th>Am Checkin</th>
                        <th>Pm Checkin</th>
                        <th>Pm Check Out</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if ($checkin->am_checkin)
                                    Checked in at {{ $checkin->am_checkin_time->format('H.m') }}
                                @else
                                    Wasn't checked in
                                @endif
                            </td>
                            <td>
                                @if ($checkin->pm_checkin)
                                    Checked in at {{ $checkin->pm_checkin_time->format('H.m') }}
                                @else
                                    Wasn't Checked in
                                @endif
                            </td>
                            <td>
                                @if ($checkin->pm_checkout)
                                    Checked out at {{ $checkin->pm_checkout_time->format('H.m') }}
                                @elseif ($checkin->pm_checkin && !$checkin->pm_checkout)
                                    Wasn't Checked out
                                @else
                                    Wasn't Checked in
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </div>
        </div>

    </div>
@endsection

