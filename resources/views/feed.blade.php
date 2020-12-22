@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/feed.css') }}" rel="stylesheet">
@endsection

@section("scripts")
<script src="{{ asset('javascript/feedScroll.js') }}" defer></script>
@endsection

@section('title')
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section('pre-main')
<div id="feed-nav">
    <div id="nav-top">
        {{-- Search bar --}}
        <div id="search-box" class="form-box">
            <svg id="search-icon">
                <use xlink:href="{{ asset('images/graphics/search.svg#icon') }}"></use>
            </svg>
            <input id="search-bar" type="text" name="search" placeholder="I'm looking for..." onfocus="this.placeholder = ''" onfocusout="this.placeholder = 'I\'m looking for...'" />
        </div>
        <div id="user-buttons">
            <button onclick="window.location.href='{{ route('login') }}'">Login</button>
            <button onclick="window.location.href='{{ route('register') }}'">Sign Up</button>
        </div>
    </div>
    <div class="screen-split-horizontal"></div>
    <div id="nav-bottom">
        <div id="all">
            <svg>
                <use xlink:href="{{ asset('images/graphics/all.svg#icon') }}"></use>
            </svg>
            <h1>All</h1>
        </div>
        <div id="blogs" class="active">
            <svg>
                <use xlink:href="{{ asset('images/graphics/blogs.svg#icon') }}"></use>
            </svg>
            <h1>Blogs</h1>
        </div>
        <div id="images">
            <svg>
                <use xlink:href="{{ asset('images/graphics/image.svg#icon') }}"></use>
            </svg>
            <h1>Images</h1>
        </div>
        <div id="news">
            <svg>
                <use xlink:href="{{ asset('images/graphics/news.svg#icon') }}"></use>
            </svg>
            <h1>News</h1>
        </div>
    </div>
</div>
@endsection
@section('content')
@foreach($posts as $post)
<div class="content-panel">
    <div class="overlay">
        <button>Show more</button>
    </div>
    <div class="author-info">
        <div class="profile-image-container">
            <div class="profile-image">
                <img src="{{ asset('images/profile-default.png') }}" alt="{{ $post->user->first_name }} {{ $post->user->last_name }}">
            </div>
        </div>
        <div>
            <h3>{{ $post->user->first_name }} {{ $post->user->last_name }}</h3>
            <p>{{ date("j F Y", strtotime($post->created_at)) }} • post_id: {{ $post->post_id }}</p>
        </div>
    </div>
    <h1><b>{{ $post->title }}</b></h1>
    <div class="tag-container">
        <a href="#" class="home">Home</a>
        <a href="#" class="technology">Technology</a>
        <a href="#" class="work">Work</a>
    </div>
    <p>{{ $post->content }}</p>
    <div class="comment-container">
    @if($post->comments()->count() > 0)
        <h3>Top Comment:</h3>
        @foreach($post->comments as $comment)
        <div class="comment">
            <div class="author-info">
                <div class="profile-image-container">
                    <div class="profile-image">
                        <img src="{{ asset('images/profile-default.png') }}" alt="{{ $comment->user->first_name }} {{ $comment->user->last_name }}">
                    </div>
                </div>
                <div>
                    <h3>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</h3>
                    <p>{{ date("j F Y", strtotime($comment->created_at)) }} • post_id: {{ $comment->post_id }}</p>
                </div>
            </div>
            <p>{{ $comment->content }} • comment_id: {{ $comment->comment_id }} </p>
        </div>
        {{-- <div class="replies-panel">
            @foreach($comment->replies as $reply)
                <p>{{ $reply->user->first_name }} {{ $reply->user->last_name }} • {{ date("j F Y", strtotime($reply->created_at)) }} • comment_id: {{ $reply->comment_id }}</p>
                <p>{{ $reply->content }}</p>
            @endforeach
        </div> --}}
        @endforeach
    @else
        {{-- <div class="comment"> --}}
        <i>This post has no comments yet!</i>
        {{-- </div> --}}
    @endif
    </div>
</div>
@endforeach

{{-- <div _id="screen-split"></div>
<nav>
Authentication Link
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
</nav> --}}

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
