@extends("layouts.app")

@section("styles")
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection

@section("title")
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section("content")
{{-- <main> --}}
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

        <button type="submit" class="btn btn-primary">
            {{ __('Register') }}
        </button>
    </form>

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

