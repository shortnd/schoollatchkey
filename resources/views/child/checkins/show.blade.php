@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-content-center">
                <h2>
                    {{-- <a href=""> --}}
                        {{ $child->fullName() }}
                    {{-- </a> --}}
                </h2>
                <a class="d-block" href="{{ route('school:children.checkin-edit', [$school, $child, $checkin]) }}">Edit</a>
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
                                @if ($checkin->pm_checkin_time)
                                    {{ $checkin->pmCheckinTime() }}
                                @else
                                    Wasn't Checked in.
                                @endif
                            </td>
                            <td>
                                @if ($checkin->pm_checkout_time)
                                    @if ($checkin->pm_checkout)
                                        {{ $checkin->pmCheckoutTime() }}
                                    @else
                                        Not Checked out of Latchkey
                                    @endif
                                @else
                                    <strong>Student not in afternoon latchkey</strong>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                @if ($checkin->pm_sig)
                <div class="d-flex justify-content-end align-content-end">
                    <img src="{{ $checkin->pm_sig }}" alt="pm signature" class="signature">
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

