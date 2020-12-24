@foreach($replies as $reply)
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
@endforeach
