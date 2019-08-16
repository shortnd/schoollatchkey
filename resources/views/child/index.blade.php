@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($children->count())

            @foreach($children as $child)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $child->first_name }}
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                Am Checkin: @if ($child->todayCheckin->am_in) {{ $child->todayCheckin->am_in }} @else No Am Checkin @endif
                            </div>
                            <div class="col-md-4">
                                Pm Checkin: @if ($child->todayCheckin->pm_in) {{ Carbon\Carbon::parse($child->todayCheckin->pm_in)->diffForHumans() }} @else Not Checkin for PM @endif
                            </div>
                            <div class="col-md-4">
                                @if ($child->todayCheckin->pm_in)
                                    @unless ($child->todayCheckin->pm_out)
                                        Pm Checkout {{ date($child->todayCheckin->pm_out)->diffForHumans() }}
                                    @else
                                        Still Checkin for PM Latchkey
                                    @endunless
                                @else
                                    NOT CHECKIN IN FOR PM
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @if (date('H') < 9)
                    <form action="{{ route('school:children.am-in', [$school, $child]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label for="am_in" class="form-check-label">AM Checkin
                            <input type="checkbox" name="am_in" id="am_in" onchange="this.form.submit()" checked="{{ ($child->todayCheckin->am_in ? true : false) }}>
                        </label>
                    </form>
                    @elseif (date('H') > 9 && date('H') < 21 && $child->todayCheckin->pm_in)
                    <form action="{{ route('school:children.pm-out', [$school, $child]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label for="pm_out" class="form-check-label">PM Checkout
                            <input type="checkbox" name="pm_out" id="pm_out" onchange="this.form.submit()" checked="{{ ($child->todayCheckin->pm_out ? true : false) }}">
                        </label>
                    </form>
                    @elseif (date('H') > 9 && date('H') < 21 && ($child->todayCheckin->pm_in && $child->todayCheckin->pm_out))
                    <form action="{{ route('school:children.pm-in', [$school, $child]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label for="pm_in" class="form-check-label">PM Checkin
                            <input type="checkbox" name="pm_in" id="pm_in" onchange="this.form.submit()" checked="{{ ($child->todayCheckin->pm_in ? true : false) }}">
                        </label>
                    </form>
                    @else
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <h2 class="h4 text-center">No Children in this school</h2>
            @auth
            <a href="{{ route('school:children.create', $school) }}">Add Children</a>
            @endauth
        @endif
    </div>
    <script>
        // const time = setInterval(() => {
        //     const now = Date.now();
        //     console.log(now)
        // }, 1000)
    </script>
@endsection
