@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section("scripts")
<script src="{{ asset('javascript/profile/global.js') }}" defer></script>
@if(Request::is('Me') && Auth::check())
<script src="{{ asset('javascript/profile/me.js') }}" defer></script>
@endif
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

<div id="profile-nav">
    <div id="about" class="menu-item active">
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/about.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>About</h1>
    </div>
    <div id="posts" class="menu-item">
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/post.svg#icon') }}"></use>
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
    {{-- <div id="settings" class="menu-item" >
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/cog.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Edit Profile</h1>
    </div> --}}
    @endif
</div>
<div class="screen-split-horizontal"></div>
<div id="profile-content">
    {{-- <svg class="loading-graphic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82.1853 82.8107" style="display: none">
        <g fill-rule="evenodd">
            <path class="elem" d="M57.12 25.724c0-2.412 1.9547-4.3666 4.3667-4.3666H77.151c2.412 0 4.366 1.9546 4.366 4.3666v15.6654c0 2.412-1.954 4.3666-4.366 4.3666H61.4867c-2.412 0-4.3667-1.9546-4.3667-4.3666z"/>
            <path class="elem" d="M.6653 5.084C.6653 2.644 2.644.6654 5.084.6654h43.2587c2.44 0 4.4186 1.9786 4.4186 4.4186v20.6174c0 2.44-1.9786 4.4186-4.4186 4.4186H5.084c-2.44 0-4.4187-1.9786-4.4187-4.4186z"/>
            <path class="elem" d="M13.992 63.948c-2.5107-2.508-2.5107-6.576 0-9.0866l16.2973-16.296c2.5107-2.5107 6.5787-2.5107 9.0867 0L55.6773 54.864c2.508 2.508 2.508 6.5787 0 9.0867l-16.3 16.299c-2.508 2.508-6.5773 2.508-9.0853 0z"/>
        </g>
    </svg> --}}
    <div id="about-container">
        <h1>About Me</h1>
        @if(isset($user->profile->about_me))
        <p id="bio">{{ $user->profile->about_me }}</p>
        @else
        <p id="bio"><i>{{ $user->first_name }} hasn't written a bio yet</i></p>
        @endif
        <h1>Profile stats</h1>
        <p>Posts: {{ count($user->posts) }}</p>
        <p>Comments: {{ count($user->comments) }}</p>
        <p>Likes: {{ count($user->likes) }}</p>
    </div>
    <div id="posts-container" style="display: none">
    @forelse ($user->posts()->orderBy('created_at', 'DESC')->get() as $post)
        <div class="content-panel">
            <input value="post-{{ $post->id }}" hidden readonly>
            <div class="overlay">
                <div class="button-container">
                    <button onclick="window.location.href='{{ route('post', $post->id) }}'">Show more</button>
                    @if(Auth::check() && Auth::user()->id == $post->user->id)
                    <button onclick="window.location.href='{{ route('post.edit', $post->id) }}'">Edit</button>
                    @endif
                </div>
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
            <a @if($user->id != $post->user->id)href="/profile/{{ $post->user->id }}" @endif()class="author-info">
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
    </div>
    @if(Request::is('Me') && Auth::check())
    <div id="likes-container" style="display: none">
    @php
        $firstLike = $user->likes()->orderBy('created_at', 'DESC')->first();
        // if the first like != null
        if($firstLike != null) {
            $date = $firstLike->created_at;
            // Get the timestamp of the first like
            if(date('dmY') == date('dmY', strtotime($date))) {
                $date = "Today";
            } else {
                $date = date("j F Y", strtotime($date));
            }
        }
    @endphp
    @if(isset($date))
        <h2>{{ $date }}</h2>
    @endif
    @forelse ($user->likes()->orderBy('created_at', 'DESC')->get() as $like)
        @if(date('dmY') != date('dmY', strtotime($like->created_at)) && $date != date("j F Y", strtotime($like->created_at)))
            <h2>{{ $date = date("j F Y", strtotime($like->created_at)) }}</h2>
        @endif
        @if($like->likeable_type == 'App\Models\Post')
            @php
                $post = App\Models\Post::where('id', $like->likeable_id)->first();
            @endphp
                <div class="content-panel">
                    <input value="post-{{ $post->id }}" hidden readonly>
                    <a class="like-link" href="{{ route('post', $post->id) }}"></a>
                    <div class="thumb-container liked">
                        <svg class="like-thumb">
                            <use xlink:href="{{ asset('images/graphics/thumb.svg#icon') }}"></use>
                        </svg>
                        <h3>{{ count($post->likes) }}</h3>
                    </div>
                    <a @if($user->id != $post->user->id)href="/profile/{{ $post->user->id }}" @endif()class="author-info">
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
                </div>
        @else
        @php
            $commentable = App\Models\Comment::where('id', $like->likeable_id)->first();
            // Check if the liked comment is a post comment or a reply
            if($commentable->commentable_type == 'App\Models\Post') {
                $comment = $commentable;
                $post = App\Models\Post::where('id', $commentable->commentable_id)->first();
            } else {
                $comment = App\Models\Comment::where('id', $commentable->commentable_id)->first();
                $post = App\Models\Post::where('id', $comment->commentable_id)->first();
            }
        @endphp
            <div class="comment">
                <input value="comment-{{ $comment->id }}" hidden>
                <a class="like-link" href="{{ route('post', $post->id) }}"></a>
                <a href="/profile/{{ $comment->user->id }}" class="author-info">
                    <div class="profile-image-container">
                        <div class="profile-image">
                            <img src="{{ asset('images/profile-default.svg') }}" alt="{{ $comment->user->first_name }} {{ $comment->user->last_name }}">
                        </div>
                    </div>
                    <div>
                        <h3>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</h3>
                        {{-- <p>{{ date("j F Y", strtotime($comment->created_at)) }} • commentable_id: {{ $comment->commentable->id }}</p> --}}
                        @if(date('dmY') == date('dmY', strtotime($comment->created_at)))
                        <p>Today • {{ date("g:ia", strtotime($comment->created_at)) }}</p>
                        @else
                        <p>{{ date("j F Y", strtotime($comment->created_at)) }}</p>
                        @endif
                    </div>
                </a>
                {{-- <p>{{ $comment->content }} • comment_id: {{ $comment->id }} </p> --}}
                <p>{{ $comment->content }}</p>
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
                        <use xlink:href="{{ asset('images/graphics/thumb.svg#icon') }}"></use>
                    </svg>
                    <h4>{{ count($comment->likes) }}</h4>
                </div>
            </div>
        @endif

    @empty
        <p>You haven't liked anything yet!</p>
    @endforelse
    </div>
    @endif
</div>


@endsection

@section('overlays')
@auth
<div id="edit-profile" style="display: none">
    <div id="edit-nav">

    </div>
    <div id="edit-container">

    </div>
    <p class="close-prompt">Close</p>
    {{-- @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
    @livewire('profile.update-profile-information-form')
    <x-jet-section-border />
    @endif

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
    <div>
        @livewire('profile.update-password-form')
    </div>
    <x-jet-section-border />
    @endif

    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    <div>
        @livewire('profile.two-factor-authentication-form')
    </div>
    <x-jet-section-border />
    @endif

    <div>
    @livewire('profile.logout-other-browser-sessions-form')
    </div>
    <x-jet-section-border />

    <div>
    @livewire('profile.delete-user-form')
    </div> --}}
</div>
@endauth
@endsection
