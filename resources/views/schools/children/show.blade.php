@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">{{ $child->fullName() }}</h2>
        @role('staff|admin')
        @if ($child->room_number)
            <h3 class="mb-3">Room Number: {{ $child->room_number }}</h3>
        @endif
        @endrole
        <div class="mb-3 d-flex align-content-around justify-content-around">
            <a href="{{ route('school:children.all-checkins', [$school, $child]) }}" class="d-block">All Checkins</a>
            <a href="{{ route('school:children.search-checkins', [$school, $child]) }}" class="d-block">Search Checkins</a>
        </div>

        @if ($past_due)
            <div class="alert alert-danger">
                Amount Past Due: ${{ $past_due }}
                <br>
                <a href="{{ route('school:children.show-payment-form', [$school, $child]) }}">Make Payment</a>
            </div>
        @endif

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
                                @if ($today_checkin->am_checkin)
                                    {{ $today_checkin->amCheckinTime() }}
                                @else
                                    Not Checked in Today
                                @endif
                            </td>
                            <td>
                                @if ($today_checkin->pm_checkin)
                                    {{ $today_checkin->pmCheckinTime() }}
                                @else
                                    Not Checked in today
                                @endif
                            </td>
                            <td>
                                @if (!$today_checkin->pm_checkin)
                                <strong>Student not checked in today</strong>
                                @else
                                    @if ($today_checkin->pmCheckoutTime())
                                        {{ $today_checkin->pmCheckoutTime() }}
                                    @else
                                        Not Checked out yet
                                    @endif
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
                                    Checked in at {{ $checkin->amCheckinTime() }}
                                @else
                                    Wasn't checked in
                                @endif
                            </td>
                            <td>
                                @if ($checkin->pm_checkin)
                                    Checked in at {{ $checkin->pmCheckinTime() }}
                                @else
                                    Wasn't Checked in
                                @endif
                            </td>
                            <td>
                                @if ($checkin->pm_checkout)
                                    Checked out at {{ $checkin->pmCheckoutTime() }}
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
            <div class="card-footer">
                Current Week Total: ${{ $current_week_total }} - <a href="{{ route('school:children.show-payment-form', [$school, $child]) }}">Make Payment</a>
            </div>
        </div>

    </div>
@endsection

