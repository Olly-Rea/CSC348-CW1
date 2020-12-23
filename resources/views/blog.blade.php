@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/blog.css') }}" rel="stylesheet">
@endsection

{{-- @section("scripts")
<script src="{{ asset('javascript/blog.js') }}" defer></script>
@endsection --}}

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
</div>
@endsection
@section('content')
<div class="content-panel">
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

</div>


{{-- <div class="screen-split-vertical"></div> --}}
<div class="screen-split-horizontal"></div>

<div class="comment-container">
@if($post->comments()->count() > 0)
    @foreach($post->comments()->orderBy('created_at', 'DESC')->get() as $comment)
    <div class="comment">
        <div class="author-info">
            <div class="profile-image-container">
                <div class="profile-image">
                    <img src="{{ asset('images/profile-default.png') }}" alt="{{ $comment->user->first_name }} {{ $comment->user->last_name }}">
                </div>
            </div>
            <div>
                <h3>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</h3>
                <p>{{ date("j F Y", strtotime($comment->created_at)) }} • post_id: {{ $comment->id }}</p>
            </div>
        </div>
        <p>{{ $comment->content }} • comment_id: {{ $comment->id }} </p>
    </div>
    <div class="replies-panel">
        @foreach($comment->replies as $reply)
            <p>{{ $reply->user->first_name }} {{ $reply->user->last_name }} • {{ date("j F Y", strtotime($reply->created_at)) }} • comment_id: {{ $reply->id }}</p>
            <p>{{ $reply->content }}</p>
        @endforeach
    </div>
    @endforeach
@else
    <p><i>This post has no comments yet!</i></p>
@endif

<form action="">
    <div class="form-box">
        <input type="text" name="comment" placeholder="Type your comment here!" onfocusout="this.placeholder = 'Type your comment here!'" />
    </div>
</form>

</div>
@endsection
