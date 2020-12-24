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
<div id="feed-nav" style="display: none">
    <div id="nav-top">
        {{-- Search bar --}}
        <form id="search-box" action="">
            <div class="form-box">
                <svg id="search-icon">
                    <use xlink:href="{{ asset('images/graphics/search.svg#icon') }}"></use>
                </svg>
                <input id="search-bar" type="text" name="search" placeholder="I'm looking for..." onfocus="this.placeholder = ''" onfocusout="this.placeholder = 'I\'m looking for...'" />
            </div>
        </form>
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
@forelse($posts as $post)
<div class="content-panel">
    <div class="overlay">
        <button onclick="window.location.href='{{ route('post', $post->id) }}'">Show more</button>
    </div>
    <div class="thumb-container">
        <svg class="like-thumb">
            <use xlink:href="{{ asset('images/graphics/thumb.svg#icon') }}"></use>
        </svg>
        <h3>{{ count($post->likes) }}</h3>
    </div>
    <div class="author-info">
        <div class="profile-image-container">
            <div class="profile-image">
                <img src="{{ asset('images/profile-default.png') }}" alt="{{ $post->user->first_name }} {{ $post->user->last_name }}">
            </div>
        </div>
        <div>
            <h3>{{ $post->user->first_name }} {{ $post->user->last_name }}</h3>
            <p>{{ date("j F Y", strtotime($post->created_at)) }} • post_id: {{ $post->id }}</p>
        </div>
    </div>
    <h1><b>{{ $post->title }}</b></h1>
    <div class="tag-container">
        @forelse($post->tags as $tag)
        <a href="#" class="{{ strtolower($tag->name) }}">{{ $tag->name }}</a>
        @empty
        <p>No Tags!</p>
        @endforelse
    </div>
    {{-- <p>{{ $post->content()->first() }}</p> --}}
    <div class="comment-container">
    @if($post->comments()->count() > 0)
        <h3>Top Comment:</h3>
        @php
            $topComment = $post->comments()->withCount('likes')->orderBy('likes_count', 'DESC')->first();
        @endphp
        <div class="comment">
            <div class="author-info">
                <div class="profile-image-container">
                    <div class="profile-image">
                        <img src="{{ asset('images/profile-default.png') }}" alt="{{ $topComment->user->first_name }} {{ $topComment->user->last_name }}">
                    </div>
                </div>
                <div>
                    <h3>{{ $topComment->user->first_name }} {{ $topComment->user->last_name }}</h3>
                    <p>{{ date("j F Y", strtotime($topComment->created_at)) }} • commentable_id: {{ $topComment->commentable->id }}</p>
                </div>
            </div>
            <p>{{ $topComment->content }} • comment_id: {{ $topComment->id }} </p>
            <div class="thumb-container">
                <svg class="like-thumb">
                    <use xlink:href="{{ asset('images/graphics/thumb.svg#icon') }}"></use>
                </svg>
                <h4>{{ count($topComment->likes) }}</h4>
            </div>
        </div>
    @else
        <div class="comment">
            <p><i>This post has no comments yet!</i></p>
        </div>
    @endif
    </div>
</div>
@empty
    <p>No posts here!</p>
@endforelse
<svg class="loading-graphic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82.1853 82.8107">
    <g fill-rule="evenodd">
        <path class="elem" d="M57.12 25.724c0-2.412 1.9547-4.3666 4.3667-4.3666H77.151c2.412 0 4.366 1.9546 4.366 4.3666v15.6654c0 2.412-1.954 4.3666-4.366 4.3666H61.4867c-2.412 0-4.3667-1.9546-4.3667-4.3666z"/>
        <path class="elem" d="M.6653 5.084C.6653 2.644 2.644.6654 5.084.6654h43.2587c2.44 0 4.4186 1.9786 4.4186 4.4186v20.6174c0 2.44-1.9786 4.4186-4.4186 4.4186H5.084c-2.44 0-4.4187-1.9786-4.4187-4.4186z"/>
        <path class="elem" d="M13.992 63.948c-2.5107-2.508-2.5107-6.576 0-9.0866l16.2973-16.296c2.5107-2.5107 6.5787-2.5107 9.0867 0L55.6773 54.864c2.508 2.508 2.508 6.5787 0 9.0867l-16.3 16.299c-2.508 2.508-6.5773 2.508-9.0853 0z"/>
    </g>
</svg>
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
