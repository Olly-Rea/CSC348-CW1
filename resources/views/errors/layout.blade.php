@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/feed.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="error-container">
    <div>
        @yield('message')
    </div>
</div>
@endsection
