@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Am Checkin</h2>
        <form action="{{ route('school:children.am-in', [$school, $child, $checkin]) }}" method="post">
            @csrf
            @method('PATCH')
            <label for="am_checkin">Am Checkin
                <input type="checkbox" name="am_checkin" id="am_checkin" onchange="this.form.submit()" value="{{ $checkin->am_checkin }}">
            </label>
        </form>
        <h2>Pm Checkin</h2>
        <form action="{{ route('school:children.am-in', [$school, $child, $checkin]) }}" method="post">
            @csrf
            @method('PATCH')
            <label for="pm_checkin">Am Checkin
                <input type="checkbox" name="pm_checkin" id="pm_checkin" onchange="this.form.submit()" {{ $checkin->pm_checkin ? checked : false }}">
            </label>
        </form>
        <h2>Pm Checkout</h2>
        <form action="{{ route('school:children.pm-out', [$school, $child, $checkin]) }}" method="post">
            @csrf
            @method('PATCH')
            <label for="pm_checkout">Am Checkin
                <input type="checkbox" name="pm_checkout" id="pm_checkout" onchange="this.form.submit()" {{ $checkin->pm_checkout ? checked : false }}">
            </label>
        </form>
    </div>
@endsection
