@extends("layouts.app")

@section("styles")
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection

@section("title")
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section("content")
    <div id="demo-content">
        <div class="content-panel panel-1">
            <h1>News Stuff</h1>
        </div>
        <div class="content-panel panel-2">
            <h1>Blog Stuff</h1>
        </div>
    </div>
    <div class="screen-split-vertical"></div>
    <div id="greeting">
        <h1>BlogMeister</h1>
        <h2>Welcome to my CSC348 Coursework</h2>
        @guest
        <div id="guest-links">
            <div id="user-buttons">
                <button onclick="window.location.href='{{ route('login') }}'">Login</button>
                <button onclick="window.location.href='{{ route('register') }}'">Sign Up</button>
            </div>
            <div id="or-container">
                <div class="h-sep"></div>
                <p>Or</p>
                <div class="h-sep"></div>
            </div>
            <a href="{{ route('feed') }}">
                <div class="nav-link" >
                    {{ __('Browse as Guest') }}
                </div>
            </a>
        </div>
        @else
            <div class="nav-link" >
                {{ Auth::user()->name }}
            </div>
            <div class="nav-link" >
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" hidden>
                    @csrf
                </form>
            </div>
        @endguest
    </div>

@endsection
