@extends("layouts.app")

@section("styles")
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection

@section("title")
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section("content")
{{-- <main> --}}
    <h1>Welcome to my CSC348 Coursework</h1>
    <div id="screen-split"></div>
    <nav>
    {{-- Authentication Link --}}
    @guest
        <a href="{{ route('login') }}">
            <div class="nav-link" >
                {{ __('Login') }}
            </div>
        </a>
        @if (Route::has('register'))
        <a href="{{ route('register') }}">
            <div class="nav-link" >
                {{ __('Register') }}
            </div>
        </a>
        @endif
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
    </nav>
{{-- </main> --}}
@endsection
