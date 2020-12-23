@extends("layouts.app")

@section("styles")
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection

@section("title")
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section("content")
{{-- <main> --}}
    <div id="login-form" class="content-panel">
        <form  method="POST" action="{{ route('password.email') }}">
            @csrf

            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

            <button type="submit" class="btn btn-primary">
                {{ __('Email Password Reset Link') }}
            </button>

        </form>
    </div>

    {{-- <div id="screen-split"></div> --}}

    {{-- <nav>
    Authentication Link
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
    </nav> --}}
{{-- </main> --}}
@endsection

{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> --}}
