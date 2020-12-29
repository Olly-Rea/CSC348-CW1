@if(is_countable($comments))
    @foreach($comments as $comment)
    <div class="comment">
        <input value="comment-{{ $comment->id }}" hidden>
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
    @endforeach
@else
    @php
        $comment = $comments;
    @endphp
    <div class="comment">
        <input value="comment-{{ $comment->id }}" hidden>
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
    @if($comment->commentable_type == 'App\Models\Post')
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
        <form class="reply-form" style="display: none">
            <input type="hidden" value="comment-{{ $comment->id }}" hidden readonly>
            <div class="form-box">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/pen.svg#icon') }}"></use>
                </svg>
                <input type="text" name="reply" placeholder="Type your reply here!" onfocusout="this.placeholder = 'Type your reply here!'" autocomplete="off"/>
            </div>
        </form>
    </div>
    @endif
@endif
