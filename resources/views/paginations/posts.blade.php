@foreach($posts as $post)
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
@endforeach
