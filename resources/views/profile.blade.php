@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section("scripts")
<script src="{{ asset('javascript/replies.js') }}" defer></script>
@endsection

@section('title')
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
<div class="profile-image-container">
    <div class="profile-image">
        <img src="{{ asset('images/profile-default.svg') }}" alt="{{ $user->first_name }} {{ $user->last_name }}">
    </div>
</div>
<h1 id="user-name">{{ $user->first_name }} {{ $user->last_name }}</h1>
@if($user->site_admin || $user->system_admin)
<h4>@if($user->site_admin)Site Admin @elseif($user->system_admin)System Admin @endif</h4>
@endif
<h3>Member since {{ date("j F Y", strtotime($user->created_at)) }}</h3>
{{-- <div class="content-panel">
    <p>Posts: {{ count($user->posts) }}</p>
    <p>Comments: {{ count($user->comments) }}</p>
    <p>Likes: {{ count($user->likes) }}</p>
</div> --}}
<div id="profile-nav">
    <div id="about" class="menu-item @if(Request::is('feed/blogs'))active @endif">
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/about.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>About</h1>
    </div>
    <div id="posts" class="menu-item @if(Request::is('feed/blogs'))active @endif">
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/blogs.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Posts</h1>
    </div>
    @if (Request::is('Me'))
    <div id="likes" class="menu-item" >
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/thumb.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Likes</h1>
    </div>
    <div id="settings" class="menu-item" >
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/cog.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Edit Profile</h1>
    </div>
    @endif
</div>

{{-- -------------------------------------------------------------------------------------------------- --}}

{{-- @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
    @livewire('profile.update-profile-information-form')

    <x-jet-section-border />
@endif

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
    <div class="mt-10 sm:mt-0">
        @livewire('profile.update-password-form')
    </div>

    <x-jet-section-border />
@endif

@if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    <div class="mt-10 sm:mt-0">
        @livewire('profile.two-factor-authentication-form')
    </div>

    <x-jet-section-border />
@endif

<div class="mt-10 sm:mt-0">
    @livewire('profile.logout-other-browser-sessions-form')
</div>

<x-jet-section-border />

<div class="mt-10 sm:mt-0">
    @livewire('profile.delete-user-form')
</div> --}}

{{-- -------------------------------------------------------------------------------------------------- --}}

{{-- <h1>@if(Request::is('Me'))My @else(){{ $user->first_name }}'s @endif()Posts</h1> --}}

<div class="screen-split-horizontal"></div>

@forelse ($user->posts as $post)
<div class="content-panel">
    <input value="post-{{ $post->id }}" hidden readonly>
    <div class="overlay">
        <button onclick="window.location.href='{{ route('post', $post->id) }}'">Show more</button>
    </div>
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
            {{-- <p>{{ date("j F Y", strtotime($post->created_at)) }} • post_id: {{ $post->id }}</p> --}}
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
    <div class="content-preview">
    @php
        $firstContent = $post->content->first();
    @endphp
    @if($firstContent->type == 'text')
        <p>{{ $firstContent->content }}</p>
    @endif
    @if($firstContent->type == 'image')
        <div class="image-container">
            <img src="{{ $firstContent->loadImage() }}">
        </div>
    @endif
        <div class="content-fadeout"></div>
    </div>
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
                        <img src="{{ asset('images/profile-default.svg') }}" alt="{{ $topComment->user->first_name }} {{ $topComment->user->last_name }}">
                    </div>
                </div>
                <div>
                    <h3>{{ $topComment->user->first_name }} {{ $topComment->user->last_name }}</h3>
                    {{-- <p>{{ date("j F Y", strtotime($topComment->created_at)) }} • commentable_id: {{ $topComment->commentable->id }}</p> --}}
                    @if(date('dmY') == date('dmY', strtotime($topComment->created_at)))
                    <p>Today • {{ date("g:ia", strtotime($topComment->created_at)) }}</p>
                    @else
                    <p>{{ date("j F Y", strtotime($topComment->created_at)) }}</p>
                    @endif
                </div>
            </div>
            {{-- <p>{{ $topComment->content }} • comment_id: {{ $topComment->id }}</p> --}}
            <p>{{ $topComment->content }}</p>
            @php
                if (Auth::check()) {
                    $hasLike = $topComment->likes->contains(function ($like) {
                        return $like->user_id == Auth::user()->id;
                    });
                } else {
                    $hasLike = false;
                }
            @endphp
            <div class="thumb-container @if($hasLike)liked @endif">
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
<p>@if(Request::is('Me'))You have @else()This user has @endif()no posts yet!</p>
@endforelse

@endsection
