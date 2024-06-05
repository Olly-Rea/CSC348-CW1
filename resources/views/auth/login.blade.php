@extends("layouts.global")

@section("styles")
<link href="{{ secure_asset('css/welcome.css') }}" rel="stylesheet">
@endsection

@section("title")
{{ config('app.name', 'Laravel') }}
@endsection

@section("content")
    <div id="login-form" class="content-panel">
        <form  method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @if ($errors->has('email'))<p class="form-error-msg">{{ $errors->first('email') }}</p> @endif
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @if ($errors->has('password'))<p class="form-error-msg">{{ $errors->first('password') }}</p> @endif
            <label class="checkOption">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkbox">
                    <svg>
                        <use xlink:href="{{ secure_asset('images/graphics/checkbox.svg#icon') }}"></use>
                    </svg>
                    Remember Me
                </span>
            </label>
            <button type="submit" class="btn btn-primary">
                {{ __('Login') }}
            </button>
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </form>
    </div>
    <a href="{{ route('register') }}">Don't have an account? Sign up here!</a>
@endsection
