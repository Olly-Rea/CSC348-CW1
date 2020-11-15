@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/feed.css') }}" rel="stylesheet">
@endsection

@section('title')
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
{{-- @foreach ($posts as $post) --}}
@foreach($posts as $post)
<div class="post-panel">
    <p>{{ $post->user->first_name }} {{ $post->user->last_name }} • <i>{{ date("j F Y", strtotime($post->created_at)) }} • post_id: {{ $post->post_id }}</i></p>
    <h1><b>{{ $post->title }}</b></h1>
    <p>{{ $post->content }}</p>
    <div class="comments-panel">
    @foreach($post->comments as $comment)
        <p>{{ $comment->user->first_name }} {{ $comment->user->last_name }} • {{ date("j F Y", strtotime($comment->created_at)) }} • post_id: {{ $comment->post_id }}</p>
        <p>{{ $comment->content }} • comment_id: {{ $comment->comment_id }} </p>
        <div class="replies-panel">
            @foreach($comment->replies as $reply)
                <p>{{ $reply->user->first_name }} {{ $reply->user->last_name }} • {{ date("j F Y", strtotime($reply->created_at)) }} • comment_id: {{ $reply->comment_id }}</p>
                <p>{{ $reply->content }}</p>
            @endforeach
            </div>
    @endforeach
    </div>
</div>
@endforeach
{{-- @endforeach --}}

<div _id="screen-split"></div>
<nav>
{{-- Authentication Link --}}
    <a href="#">
        <div class="nav-link" >
            {{ __('Post Feed') }}
        </div>
    </a>
    <a href="#">
        <div class="nav-link" >
            {{ __('Search') }}
        </div>
    </a>
    @auth
    <a href="#">
        <div class="nav-link" >
            {{ __('My Posts') }}
        </div>
    </a>
    @else
    <a href="{{ route('register') }}">
        <div class="nav-link" >
            {{ __('Sign Up') }}
        </div>
    </a>
    @endauth
</nav>

{{-- @guest
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
    <div _id="or-container">
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
<a class="nav-link" >
    {{ Auth::user()->name }}
</a>
<div class="nav-link" >
    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementBy_id('logout-form').submit();">
        {{ __('Logout') }}
    </a>
    <form _id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" h_idden>
        @csrf
    </form>
</div>
@endguest --}}
@endsection
