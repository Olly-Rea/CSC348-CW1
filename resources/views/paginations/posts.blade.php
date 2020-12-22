@foreach($posts as $post)
<div class="content-panel">
    <div class="overlay">
        <button>Show more</button>
    </div>
    <div class="author-info">
        <div class="profile-image-container">
            <div class="profile-image">
                <img src="{{ asset('images/profile-default.png') }}" alt="{{ $post->user->first_name }} {{ $post->user->last_name }}">
            </div>
        </div>
        <div>
            <h3>{{ $post->user->first_name }} {{ $post->user->last_name }}</h3>
            <p>{{ date("j F Y", strtotime($post->created_at)) }} • post_id: {{ $post->post_id }}</p>
        </div>
    </div>
    <h1><b>{{ $post->title }}</b></h1>
    <div class="tag-container">
        <a href="#" class="home">Home</a>
        <a href="#" class="technology">Technology</a>
        <a href="#" class="work">Work</a>
    </div>
    <p>{{ $post->content }}</p>
    <div class="comment-container">
    @if($post->comments()->count() > 0)
        <h3>Top Comment:</h3>
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
                    <p>{{ date("j F Y", strtotime($comment->created_at)) }} • post_id: {{ $comment->post_id }}</p>
                </div>
            </div>
            <p>{{ $comment->content }} • comment_id: {{ $comment->comment_id }} </p>
        </div>
        {{-- <div class="replies-panel">
            @foreach($comment->replies as $reply)
                <p>{{ $reply->user->first_name }} {{ $reply->user->last_name }} • {{ date("j F Y", strtotime($reply->created_at)) }} • comment_id: {{ $reply->comment_id }}</p>
                <p>{{ $reply->content }}</p>
            @endforeach
        </div> --}}
        @endforeach
    @else
        {{-- <div class="comment"> --}}
        <i>This post has no comments yet!</i>
        {{-- </div> --}}
    @endif
    </div>
</div>
@endforeach
