@extends('layouts.app')

@section('content')
    <div class="card container p-3">
        <div class="card-header">
            <h2>
                <a href="">
                    {{ $child->fullName() }}
                </a>
            </h2>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>Day</th>
                    <th>Am Checkin</th>
                    <th>Pm Checkin</th>
                    <th>Pm Checkout</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $checkin->created_at->format('M d') }}
                        </td>
                        <td>
                            {{
                                $checkin->am_checkin
                                    ? "Checkin in at {$checkin->am_checkin_time}"
                                    : "Wans't Checkin In"
                            }}
                        </td>
                        <td>
                            {{
                                $checkin->pm_checkin
                                    ? "Checked in at {$checkin->pm_checkin_time}"
                                    : "Wasn't Checkin In"
                            }}
                        </td>
                        <td>
                            @if ($checkin->pm_checkout_time)
                                Checkout time??
                            @else
                                <strong>Student not in afternoon latchkey</strong>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @if ($checkin->pm_sig)
            <div>
                <img src="{{ $checkin->pm_sig }}" alt="pm signature" class="signature">
            </div>
            @endif
        </div>
    </div>
@endsection

