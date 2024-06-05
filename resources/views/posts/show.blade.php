@extends('layouts.app')

@section("styles")
<link href="{{ secure_asset('css/post.css') }}" rel="stylesheet">
@endsection

@section("scripts")
<script src="{{ secure_asset('javascript/replies.js') }}" defer></script>
@auth
<script src="{{ secure_asset('javascript/post_forms/comment.js') }}" defer></script>
@endauth
@endsection

@section('content')
<div class="content-panel">
    <input value="post-{{ $post->id }}" hidden readonly>
    @php
        if (Auth::check()) {
            $hasLike = $post->likes->contains(function ($like) {
                return $like->user_id == Auth::user()->id;
            });
        } else {
            $hasLike = false;
        }
    @endphp
    <div class="thumb-container @if($hasLike)liked @endif">
        <svg class="like-thumb">
            <use xlink:href="{{ secure_asset('images/graphics/thumb.svg#icon') }}"></use>
        </svg>
        <h3>{{ count($post->likes) }}</h3>
    </div>
    <a href="/profile/{{ $post->user->id }}" class="author-info">
        <div class="profile-image-container">
            <div class="profile-image">
                <img src="{{ $post->user->profile->profileImage() }}" alt="{{ $post->user->first_name }} {{ $post->user->last_name }}">
            </div>
        </div>
        <div>
            <h3>{{ $post->user->first_name }} {{ $post->user->last_name }}</h3>
            @if(date('dmY') == date('dmY', strtotime($post->created_at)))
            <p>Today • {{ date("g:ia", strtotime($post->created_at)) }}</p>
            @else
            <p>{{ date("j F Y", strtotime($post->created_at)) }}</p>
            @endif
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
    <img src="{{ $content->loadImage() }}">
    @if($content->sub_content != null)
    <div class="image-caption">
        <p>{{ $content->sub_content }}</p>
    </div>
    @endif
</div>
@endif
@endforeach

<div class="screen-split-horizontal"></div>

<div id="comment-container">
@if($post->comments()->count() > 0)
    @foreach($post->comments()->orderBy('created_at', 'ASC')->get() as $comment)
    <div class="comment">
        <input value="comment-{{ $comment->id }}" hidden>
        <a href="/profile/{{ $comment->user->id }}" class="author-info">
            <div class="profile-image-container">
                <div class="profile-image">
                    <img src="{{ $comment->user->profile->profileImage() }}" alt="{{ $comment->user->first_name }} {{ $comment->user->last_name }}">
                </div>
            </div>
            <div>
                <h3>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</h3>
                @if(date('dmY') == date('dmY', strtotime($comment->created_at)))
                <p>Today • {{ date("g:ia", strtotime($comment->created_at)) }}</p>
                @else
                <p>{{ date("j F Y", strtotime($comment->created_at)) }}</p>
                @endif
            </div>
        </a>
        @if(Auth::check() && Auth::user()->id == $comment->user->id)
        <form class="comment-edit" style="display: none">
            <input name="comment" type="text" value="{{ $comment->content }}" autocomplete="off">
            <p class="form-cancel">Cancel</p>
        </form>
        <p>{{ $comment->content }}</p>
        @else
        <p>{{ $comment->content }}</p>
        @endif
        @php
            if (Auth::check()) {
                $hasLike = $comment->likes->contains(function ($like) {
                    return $like->user_id == Auth::user()->id;
                });
            } else {
                $hasLike = false;
            }
        @endphp
        <div class="thumb-container @if($hasLike)liked @endif">
            <svg class="like-thumb">
                <use xlink:href="{{ secure_asset('images/graphics/thumb.svg#icon') }}"></use>
            </svg>
            <h4>{{ count($comment->likes) }}</h4>
        </div>
        @if(Auth::check() && Auth::user()->id == $comment->user->id)
        <div class="overlay">
            <div id="edit" class="menu-item">
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/pen.svg#icon') }}"></use>
                </svg>
            </div>
            <div id="delete" class="menu-item" >
                <form class="comment-delete" action="{{ route('comment.delete', $comment->id) }}" method="POST" style="display: none" hidden>
                    @csrf
                </form>
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/delete.svg#icon') }}"></use>
                </svg>
            </div>
        </div>
        @endif
    </div>
    <div class="reply-button">
        <svg>
            <use xlink:href="{{ secure_asset('images/graphics/reply.svg#icon') }}"></use>
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
        <form class="reply-form" style="display: none">
            <input type="hidden" value="comment-{{ $comment->id }}" hidden readonly>
            <div class="form-box">
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/pen.svg#icon') }}"></use>
                </svg>
                <input type="text" name="reply" placeholder="Type your reply here!" onfocusout="this.placeholder = 'Type your reply here!'" autocomplete="off"/>
            </div>
        </form>
    </div>
    @endforeach
@else
    <p class="empty">This post has no comments yet!</p>
@endif
</div>
<form id="comment-form">
    <input type="hidden" value="post-{{ $post->id }}" hidden readonly>
    <div class="form-box">
        <svg>
            <use xlink:href="{{ secure_asset('images/graphics/pen.svg#icon') }}"></use>
        </svg>
        <input type="text" name="comment" placeholder="Type your comment here!" onfocusout="this.placeholder = 'Type your comment here!'" autocomplete="off"/>
    </div>
</form>
@endsection
