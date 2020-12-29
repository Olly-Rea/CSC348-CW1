@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/post.css') }}" rel="stylesheet">
@endsection

{{-- @section("scripts")
<script src="{{ asset('javascript/replies.js') }}" defer></script>
@endsection --}}

@section('title')
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')



@endsection
