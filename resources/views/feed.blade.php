@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/feed.css') }}" rel="stylesheet">
@endsection

@section("scripts")
<script src="{{ asset('javascript/feed/onScroll.js') }}" defer></script>
<script src="{{ asset('javascript/feed/allFetch.js') }}" defer></script>
@endsection

@section('content')
@if($requestFail)
<h2>API Request Error! Only User posts shown</h2>
@else
<h2>Showing all User posts & most read stories from BBC News</h2>
@endif
@forelse($feedItems as $feedItem)
    @if(isset($feedItem["type"]))
        @php
            $news = $feedItem;
        @endphp
        @if($news["description"] != "The latest five minute news bulletin from BBC World Service.")
        <div class="content-panel">
            <div class="overlay">
                <div class="button-container">
                    <button onclick="window.open('{{ $news["url"] }}')">Show more</button>
                </div>
            </div>
            <a href="{{ $news["url"] }}" target="_blank" class="author-info">
                <div class="profile-image-container">
                    <div class="profile-image">
                        <img src="{{ asset('images/profile-default.svg') }}" alt="{{ $news["author"] }}">
                    </div>
                </div>
                <div>
                    <h3>{{ $news["author"] }}</h3>
                    @if(date('dmY') == date('dmY', strtotime($news["created_at"])))
                    <p>Today • {{ date("g:ia", strtotime($news["created_at"])) }}</p>
                    @else
                    <p>{{ date("j F Y", strtotime($news["created_at"])) }}</p>
                    @endif
                </div>
            </a>
            <h1><b>{{ $news["title"] }}</b></h1>
            <div class="content-preview">
                <div class="image-container">
                    <img src="{{ $news["urlToImage"] }}" alt="">
                </div>
                <div class="content-fadeout"></div>
            </div>
        </div>
        @endif
    @else
    @php
        $post = App\Models\Post::where('id', $feedItem['id'])->first();
    @endphp
    <div class="content-panel">
        <input value="post-{{ $post->id }}" hidden readonly>
        <div class="overlay">
            <div class="button-container">
                <button onclick="window.location.href='{{ route('post', $post->id) }}'">Show more</button>
                @if(Auth::check() && Auth::user()->id == $post->user->id) {
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
                    <h4>{{ $topComment->likes_count }}</h4>
                </div>
            </div>
        @else
            <div class="comment">
                <p><i>This post has no comments yet!</i></p>
            </div>
        @endif
        </div>
    </div>
    @endif
@empty
    <p>No news here!</p>
@endforelse
<svg class="loading-graphic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82.1853 82.8107">
    <g fill-rule="evenodd">
        <path class="elem" d="M57.12 25.724c0-2.412 1.9547-4.3666 4.3667-4.3666H77.151c2.412 0 4.366 1.9546 4.366 4.3666v15.6654c0 2.412-1.954 4.3666-4.366 4.3666H61.4867c-2.412 0-4.3667-1.9546-4.3667-4.3666z"/>
        <path class="elem" d="M.6653 5.084C.6653 2.644 2.644.6654 5.084.6654h43.2587c2.44 0 4.4186 1.9786 4.4186 4.4186v20.6174c0 2.44-1.9786 4.4186-4.4186 4.4186H5.084c-2.44 0-4.4187-1.9786-4.4187-4.4186z"/>
        <path class="elem" d="M13.992 63.948c-2.5107-2.508-2.5107-6.576 0-9.0866l16.2973-16.296c2.5107-2.5107 6.5787-2.5107 9.0867 0L55.6773 54.864c2.508 2.508 2.508 6.5787 0 9.0867l-16.3 16.299c-2.508 2.508-6.5773 2.508-9.0853 0z"/>
    </g>
</svg>
@endsection
