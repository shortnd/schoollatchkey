<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                @else
                    @if ($school)
                    <a class="navbar-brand" href="{{ route('school:school.index', $school) }}">
                        {{ $school->name }} Latchkey
                    </a>
                    @else
                    <a class="navbar-brand" href="{{ route('schools.index') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    @endif
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if ($school)
                        @role('admin|staff')
                            @if ($invitations_count)
                                <li class="nav-item">
                                    <a href="{{ route('school:show-invitations', $school) }}" class="nav-link">View Invitations</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('school:users.index', $school) }}" class="nav-link">All Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school:parents.index', $school) }}" class="nav-link">All Parents</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school:children.index', $school) }}" class="nav-link">All Children</a>
                            </li>
                        @endrole
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                @unless ($school)
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @else
                                    <a class="nav-link" href="{{ route('school:login', $school) }}">{{ __('Login') }}</a>
                                @endunless
                            </li>
                            @if (Route::has('school:show-registration') && $school)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('school:show-registration', $school) }}">{{ __('Register') }}</a>
                                </li>
                            @elseif (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route("register") }}">
                                        {{ __('Register')}}
                                    </a>
                                </li>
                            @endif
                        @else
                            @role('admin|staff')
                            @if ($school)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('school:children.create', [$school]) }}">Add Child</a>
                            </li>
                            @endif
                            @endrole
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                @unless ($school)
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                                @else
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item"
                                        href="{{ route('school:children.half-day', $school) }}"
                                        onclick="event.preventDefault(); document.getElementById('half-day-form').submit()">
                                        Half-Day
                                    </a>
                                    <form id="half-day-form" action="{{ route('school:children.half-day', $school) }}" method="POST" style="display:none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('school:logout', $school) }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('school:logout', $school) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                                @endunless
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @error('school')
                    <div class="alert alert-danger d-print-none" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                @role('staff|admin')
                @if (isset($invitations_count) && $invitations_count > 0)
                    <div class="alert alert-warning alert-dismissible fade show d-print-none" role="alert" id="invitation-count">
                        There are {{ $invitations_count }} waiting for invitation email to be sent <a href="{{ route('school:show-invitations', $school) }}">invitations</a>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                    @role('admin')
                    @if ($school)
                    @if (!$school->owner_id)
                        <div class="alert alert-danger d-print-none">
                            {{ $school->name }} has no owner, if you want to be the owner of the schools/account <a href="{{ route('schools.update-owner', $school) }}">Click Here</a>
                        </div>
                    @endif
                    @endif
                    @endrole
                @endrole
            </div>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
