@extends('layouts.app')

@section('content')
<div class="container" id="all-checkins">
        <div class="card mb-3">
            @foreach($checkins->months as $month)
            <table class="table">
                <thead>
                    <th colspan="4">{{ $month->first()->created_at->format('M') }}</th>
                </thead>
                <tbody>
                    @foreach($month as $day)
                        <tr>
                            <th>Day</th>
                            <th>AM Checkin</th>
                            <th>PM Checkin</th>
                            <th>PM Checkout</th>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{ route('school:children.checkin', [$school, $checkins, $day]) }}">
                                    {{ $day->created_at->format('D d') }}
                                </a>
                            </td>
                            <td>
                                {{ $day->am_checkin ? 'Was checked in at ' . $day->amCheckinTime() : 'Wasn\'t Checked in' }}
                            </td>
                            <td>
                                {{ $day->pm_checkin ? 'Was checked in at ' . $day->pmCheckinTime() : 'Wasn\'t Checked in' }}
                            </td>
                            <td>
                                {{ $day->pm_checkout ? 'Was checked out at ' . $day->pmCheckoutTime() : 'Wasn\'t Checked in\out' }}
                            </td>
                        </tr>
                        @if ($day->pm_sig)
                        <tr>
                            <th>
                                PM Signature
                            </th>
                            <td colspan="3">
                                <img src="{{ $day->pm_sig }}" alt="Pm Signature" class="signature">
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{-- @if ($day->pm_sig)
                <div class="d-flex justify-content-end align-content-end">
                    <img src="{{ $day->pm_sig }}" alt="Signature">
                </div>
                @endif --}}
            @endforeach
        </div>
    </div>
@endsection

