@extends("layouts.global")

@section("styles")
<link href="{{ secure_asset('css/welcome.css') }}" rel="stylesheet">
@endsection

@section("title")
{{ config('app.name', 'Laravel') }}
@endsection

@section("content")
    <div id="register-form"  class="content-panel">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @if ($errors->has('name'))<p class="form-error-msg">{{ $errors->first('name') }}</p> @endif
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            @if ($errors->has('email'))<p class="form-error-msg">{{ $errors->first('email') }}</p> @endif
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @if ($errors->has('password'))<p class="form-error-msg">{{ $errors->first('password') }}</p> @endif
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </form>
    </div>
    <a href="{{ route('login') }}">Already have an account? Login here!</a>
@endsection
