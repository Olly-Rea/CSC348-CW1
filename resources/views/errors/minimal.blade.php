@extends('layouts.global')

@section("styles")
<link href="{{ secure_asset('css/global.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="error-container">
    <div>
        <h2>@yield('code')</h2>
        <div class="seperator"></div>
        <p>@yield('message')</p>
    </div>
    <a href="{{ url()->previous() }}">Take me back</a>
</div>
@endsection
