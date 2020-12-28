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

@section('content')
<div class="content-panel">
    <div class="thumb-container">
        <svg class="like-thumb">
            <use xlink:href="{{ asset('images/graphics/thumb.svg#icon') }}"></use>
        </svg>
        <h3>{{ count($post->likes) }}</h3>
    </div>
    <a href="/profile/{{ $post->user->id }}" class="author-info">
        <div class="profile-image-container">
            <div class="profile-image">
                <img src="{{ asset('images/profile-default.svg') }}" alt="{{ $post->user->first_name }} {{ $post->user->last_name }}">
            </div>
        </div>
        <div>
            <h3>{{ $post->user->first_name }} {{ $post->user->last_name }}</h3>
            <p>{{ date("j F Y", strtotime($post->created_at)) }} • post_id: {{ $post->id }}</p>
        </div>
    </a>
    <h1><b>{{ $post->title }}</b></h1>
    <div class="tag-container">
        @forelse($post->tags as $tag)
        <a href="#" class="{{ strtolower($tag->name) }}">{{ $tag->name }}</a>
        @empty
        <p>No Tags!</p>
        @endforelse
    </div>
</div>
@foreach($post->content as $content)
@if($content->type == 'text')
<div class="content-panel">
    <p>{{ $content->content }}</p>
    @if($content->sub_content != null)
    <p>{{ $content->sub_content }}</p>
    @endif
</div>
@endif
@if($content->type == 'image')
<div class="image-panel">
    <img src="{{ $content->loadImage() }}" alt="">
    @if($content->sub_content != null)
    <div class="image-caption">
        <p>{{ $content->sub_content }}</p>
    </div>
    @endif
</div>
@endif
@endforeach

<div class="screen-split-horizontal"></div>

<div class="comment-container">
@if($post->comments()->count() > 0)
    @foreach($post->comments as $comment)
    <div class="comment">
        <a href="/profile/{{ $comment->user->id }}" class="author-info">
            <div class="profile-image-container">
                <div class="profile-image">
                    <img src="{{ asset('images/profile-default.svg') }}" alt="{{ $comment->user->first_name }} {{ $comment->user->last_name }}">
                </div>
            </div>
            <div>
                <h3>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</h3>
                <p>{{ date("j F Y", strtotime($comment->created_at)) }} • commentable_id: {{ $comment->commentable->id }}</p>
            </div>
        </a>
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
        <form id="reply-form" action="" style="display: none">
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
<form id="comment-form" action="">
    <div class="form-box">
        <svg>
            <use xlink:href="{{ asset('images/graphics/pen.svg#icon') }}"></use>
        </svg>
        <input type="text" name="comment" placeholder="Type your comment here!" onfocusout="this.placeholder = 'Type your comment here!'" />
    </div>
</form>
@endsection
