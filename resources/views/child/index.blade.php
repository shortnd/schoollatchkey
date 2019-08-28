@extends('layouts.app')

@section('content')
<div class="container">
    @auth
    @if ($children->count())
    @foreach($children as $child)
    <div class="card mb-3">
        <div class="card-header">
            {{ $child->first_name }}
            @if (count($child->checkin_totals) > 0)
            <small class="text-danger d-block">Past Due: {{ $child->pastDue() }}</small>
            @endif
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @if (now()->format('H.m') > 6.15 && now()->format('H.m') < 7.45)
                    <div class="col-md-4">
                        @if (! $child->checkins->first()->am_checkin)
                        <form action="" method="post">
                            @csrf
                            @method('PATCH')
                            <label for="am_checkin">AM Check In &nbsp;
                                <input type="checkbox" name="am_checkin" id="am_checkin"
                                    {{ $child->checkins->first()->am_checkin ? 'checked' : '' }}
                                    {{ $child->checkins->first()->am_disabled() ? 'disabled' : '' }}
                                    onchange="this.form.submit()">
                            </label>
                        </form>
                        @else
                        Checked in at {{ $child->checkins->first()->amCheckinTime() }}
                        @endif
                    </div>
                    @elseif (now()->format('H.m') > 15 && now()->format('H.m') < 17.3)
                    <div class="col-md-4">
                        @if (! $child->checkins->first()->pm_checkin)
                        <form action="" method="post">
                            @csrf
                            @method('PATCH')
                            <label for="pm_checkin">
                                PM Check In &nbsp;
                                <input type="checkbox" name="pm_checkin" id="pm_checkin"
                                    {{ $child->checkins->first()->pm_checkin ? 'checked' : '' }}
                                    {{ $child->checkins->first()->pm_disabled() ? 'disabled' : '' }}>
                            </label>
                        </form>
                        @else
                        Checked in today.
                        @endif
                    </div>
                    @elseif (now()->format('H.m') > 15 && now()->format('H.m') < 17.3 && $child->pm_checkin)
                    <div class="col-md-4">
                        @if ($child->checkins->first()->pm_checkout_time)
                        {{ $child->checkins->first()->getCheckoutTime() }}
                        <br>
                        {{ $child->checkins->first()->getCheckoutDiffHumans() }}
                        @elseif($child->checkins->first()->pm_checkin)
                        <strong>Student still in latchkey</strong>
                        @else
                        <strong>Student not in afternoon latchkey</strong>
                        @endif
                    </div>
                    @else
                    <h3 class="mx-auto">It is not time to checkin children to latchkey</h3>
                    {{-- TODO: ADD OVER RIDE ROUTE FOR HALF DAYS --}}
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
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
