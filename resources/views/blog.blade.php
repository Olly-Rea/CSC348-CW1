@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/blog.css') }}" rel="stylesheet">
@endsection

@section("scripts")
<script src="{{ asset('javascript/replies.js') }}" defer></script>
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
                <p>{{ date("j F Y", strtotime($comment->created_at)) }} • commentable_id: {{ $comment->commentable->id }}</p>
            </div>
        </div>
        <p>{{ $comment->content }} • comment_id: {{ $comment->id }} </p>
        <div class="thumb-container">
            <svg class="like-thumb">
                <use xlink:href="{{ asset('images/graphics/thumb.svg#icon') }}"></use>
            </svg>
            <h4>{{ count($comment->likes) }}</h4>
        </div>
    </div>
    <div class="reply-button">
        <svg>
            <use xlink:href="{{ asset('images/graphics/reply.svg#icon') }}"></use>
        </svg>
        <h3>Show replies</h3>
    </div>
    <div id="comment-{{ $comment->id }}" class="reply-container" style="display: none">
        <svg class="loading-graphic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82.1853 82.8107">
            <g fill-rule="evenodd">
                <path class="elem" d="M57.12 25.724c0-2.412 1.9547-4.3666 4.3667-4.3666H77.151c2.412 0 4.366 1.9546 4.366 4.3666v15.6654c0 2.412-1.954 4.3666-4.366 4.3666H61.4867c-2.412 0-4.3667-1.9546-4.3667-4.3666z"/>
                <path class="elem" d="M.6653 5.084C.6653 2.644 2.644.6654 5.084.6654h43.2587c2.44 0 4.4186 1.9786 4.4186 4.4186v20.6174c0 2.44-1.9786 4.4186-4.4186 4.4186H5.084c-2.44 0-4.4187-1.9786-4.4187-4.4186z"/>
                <path class="elem" d="M13.992 63.948c-2.5107-2.508-2.5107-6.576 0-9.0866l16.2973-16.296c2.5107-2.5107 6.5787-2.5107 9.0867 0L55.6773 54.864c2.508 2.508 2.508 6.5787 0 9.0867l-16.3 16.299c-2.508 2.508-6.5773 2.508-9.0853 0z"/>
            </g>
        </svg>
        {{-- @foreach($comment->replies as $reply)
            <div class="comment">
                <div class="author-info">
                    <div class="profile-image-container">
                        <div class="profile-image">
                            <img src="{{ asset('images/profile-default.png') }}" alt="{{ $reply->user->first_name }} {{ $reply->user->last_name }}">
                        </div>
                    </div>
                    <div>
                        <h3>{{ $reply->user->first_name }} {{ $reply->user->last_name }}</h3>
                        <p>{{ date("j F Y", strtotime($reply->created_at)) }} • post_id: {{ $reply->commentable->id }}</p>
                    </div>
                </div>
                <p>{{ $reply->content }} • comment_id: {{ $reply->id }} </p>
                <div class="thumb-container">
                    <svg class="like-thumb">
                        <use xlink:href="{{ asset('images/graphics/thumb.svg#icon') }}"></use>
                    </svg>
                    <h4>{{ count($reply->likes) }}</h4>
                </div>
            </div>
        @endforeach --}}
        <form action="" style="display: none">
            <div class="form-box">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/pen.svg#icon') }}"></use>
                </svg>
                <input type="text" name="reply" placeholder="Type your reply here!" onfocusout="this.placeholder = 'Type your reply here!'" />
            </div>
        </form>
    </div>
    @endforeach
@else
    <p>This post has no comments yet!</p>
@endif
</div>
<form action="">
    <div class="form-box">
        <svg>
            <use xlink:href="{{ asset('images/graphics/pen.svg#icon') }}"></use>
        </svg>
        <input type="text" name="comment" placeholder="Type your comment here!" onfocusout="this.placeholder = 'Type your comment here!'" />
    </div>
</form>
@endsection
