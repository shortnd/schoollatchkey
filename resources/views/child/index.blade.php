@extends('layouts.app')

@section('content')
<div class="container">
    @auth
    @if ($children->count())
    @foreach($children as $child)
    <div class="card mb-3">
        <div class="card-header">
            {{ $child->fullName() }} - <a href="{{ route('school:children.show', [$school, $child]) }}">Detail</a>
            <br>
            @role('staff|admin')
            @if ($child->room_number)
                Room Number: {{ $child->room_number }}
            @endif
            @endrole
            @if (count($child->pastDue()) > 0)
                <small class="text-danger d-block">Past Due: ${{ $child->pastDue()->sum('total_amount') }}</small>
            @endif
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @if (now()->format('H.m') > 6.15 && now()->format('H.m') < 7.45) <div class="col-md-4">
                        @if (! $child->todayCheckin()->am_checkin)
                        <form action="{{ route('school:children.am-in', [$school, $child]) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <label for="am_checkin">AM Check In &nbsp;
                                <input type="checkbox" name="am_checkin" id="am_checkin"
                                    {{ $child->checkins->latest()->am_checkin ? 'checked' : '' }}
                                    {{ $child->checkins->latest()->am_disabled() ? 'disabled' : '' }}
                                    onchange="this.form.submit()">
                            </label>
                        </form>
                        @else
                        Checked in at {{ $child->checkins->latest()->amCheckinTime() }}
                        @endif
                </div>
                @elseif ($child->todayCheckin()->pm_checkin)
                    <div class="col-md-4">
                        @if ($child->checkins->latest()->pm_checkout_time)
                        {{ $child->checkins->latest()->pmCheckoutTime() }}
                        <br>
                        {{ $child->checkins->latest()->getCheckoutDiffHumans() }}
                        @elseif($child->todayCheckin()->pm_checkin)
                        <strong>Student still in latchkey</strong>
                        @error('pm-checkout')
                        {{ $message }}
                        @enderror
                        <form action="{{ route('school:children.pm-out', [$school, $child]) }}" method="POST" class="checkout-form">
                            @csrf
                            @method('PATCH')
                            <label for="pm_checkout">PM checkout
                                <input name="pm_checkout" id="pm_checkout" type="checkbox">
                            </label>
                            @signituremodal
                        </form>
                        @else
                        <strong>Student not in afternoon latchkey</strong>
                        @endif
                    </div>
                    @elseif (now()->format('H.m') > 15.3 && now()->format('H.m') < 17.3 || $child->half_day)
                    <div class="col-md-4">
                        @if (! $child->todayCheckin()->pm_checkin)
                        <form action="{{ route('school:children.pm-in', [$school, $child]) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <label for="pm_checkin">
                                PM Check In &nbsp;
                                <input type="checkbox" name="pm_checkin" id="pm_checkin"
                                    {{ $child->checkins->latest()->pm_checkin ? 'checked' : '' }}
                                    @if ($child->checkins->latest()->pm_disabled() && !$child->half_day)
                                    disabled
                                    @endif
                                    {{-- {{ $child->checkins->latest()->pm_disabled() || $child->half_day ? 'disabled' : '' }} --}}
                                    onchange="this.form.submit()">
                            </label>
                        </form>
                        @else
                        Checked in today.
                        {{ $child->checkins->latest()->pm_checkin }} {{ now()->format('H.m') > 15.3 }}
                        {{ now()->format('H.m') < 17.3 }}
                        @endif
            </div>
            @else
            <h3 class="mx-auto">It is not time to checkin children to latchkey</h3>
            @endif
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="row">
        <div class="col-md-4 mb-3">
            <strong class="d-block mb-3">AM Checkin</strong>
            @if ($child->todayCheckin()->am_checkin_time)
                Checkin Time: {{ $child->todayCheckin()->amCheckinTime() }}
            @else
                Not Checked in Today
            @endif
        </div>
        <div class="col-md-4 mb-3">
            <strong class="d-block mb-3">PM Checkin</strong>
            @if ($child->todayCheckin()->pm_checkin)
                Checkin Time: {{ $child->todayCheckin()->pmCheckinTime() }}
            @else
                Not Checked in Today
            @endif
        </div>
        <div class="col-md-4 mb-3">
            <strong class="d-block mb-3">PM Checkout</strong>
            @if ($child->todayCheckin()->pm_checkin)
                Student still in Latchkey
            @elseif ($child->todayCheckin()->pm_checkout)
                Checkout Time: {{ $child->todayCheckin()->pmCheckoutTime() }}
            @else
                Not Checked in Today
            @endif
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-4 mb-3">
            <h5 class="d-block">AM Checkin Time</h5>
            @if ($child->checkins->first()->am_checkin)
                {{ $child->amCheckinTime() }}
            @else
            Not Checked in Today
            @endif
        </div>
        <div class="col-md-4 mb-3">
            <h5 class="d-block">PM Checkin Time</h5>
            @if ($child->checkins->first()->pm_checkin_time)
                {{ $child->pmCheckinTime() }}
            @else
            Not Checked in Today
            @endif
        </div>
        <div class="col-md-4 mb-3">
            <h5 class="d-block">PM Checkout Time</h5>
            @if ($child->checkins->first()->pm_checkin_time)
                Child Still In Latchkey
            @elseif ($child->checkins->first()->pm_checkout_time)
                {{ $child->pmCheckoutTime() }}
            @else
                No Checked in Today
            @endif
        </div>
    </div> --}}
</div>
</div>
@endforeach
@else
<h2 class="h4 text-center">No Children in this school</h2>
@auth
<a href="{{ route('school:children.create', $school) }}">Add Children</a>
@endauth
@endif
@else
<h2 class="text-center">Have an account <a href="{{ route('login') }}">Login</a> or Request Registration <a
        href="{{ route('school:request-invitation', $school) }}">here</a></h2>
@endauth
</div>
@endsection
