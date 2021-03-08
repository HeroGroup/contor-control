<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="/css/my.css" rel="stylesheet" type="text/css">
</head>
<body dir="rtl" style="background-image: url('/images/Login_body.jpg'); background-repeat: repeat;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav" style="text-align: right;">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">ورود</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">ثبت نام</a>
                                </li>
                            @endif
                        @else
                            @if(auth()->user())
                                <li class="bb">
                                    <a class="dropdown-item" href="/editProfile">پروفایل {{ Auth::user()->name }}</a>
                                </li>
                            @endif
                            @role('installer')
                            <li class="bb">
                                <a class="dropdown-item" href="/newGatewayTypeB">درگاه تایپ B جدید</a>
                            </li>
                            <li class="bb">
                                <a class="dropdown-item" href="/newGatewayTypeA">درگاه تایپ A جدید</a>
                            </li>
                            <li class="bb">
                                <a class="dropdown-item" href="/newSplit">اسپلیت جدید</a>
                            </li>
                            @endrole
                            <li>
                                <a class="dropdown-item" style="color:red;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    خروج
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" style="text-align: right;">
            @yield('content')
        </main>
    </div>
</body>
</html>
