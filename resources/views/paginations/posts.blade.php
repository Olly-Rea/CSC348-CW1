@foreach($posts as $post)
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
                    <p>{{ date("j F Y", strtotime($topComment->created_at)) }} • post_id: {{ $topComment->commentable->id }}</p>
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
@endforeach
