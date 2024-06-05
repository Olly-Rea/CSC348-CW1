@extends('layouts.app')

@section("styles")
<link href="{{ secure_asset('css/feed.css') }}" rel="stylesheet">
@endsection

@section("scripts")
@if(!$requestFail)
<script src="{{ secure_asset('javascript/feed/onScroll.js') }}" defer></script>
<script src="{{ secure_asset('javascript/feed/newsFetch.js') }}" defer></script>
@endif
@endsection

@section('content')
@if($requestFail)
<h2 style="transform: translateY(calc(40vh - 50%))">API Request Error! Please try again later</h2>
@else
    <h2>Showing latest stories from BBC News</h2>
    @forelse($news as $news)
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
                        <img src="{{ secure_asset('images/profile-default.svg') }}" alt="{{ $news["author"] }}">
                    </div>
                </div>
                <div>
                    <h3>{{ $news["author"] }}</h3>
                    {{-- <p>{{ date("j F Y", strtotime($news->created_at)) }} • news_id: {{ $news->id }}</p> --}}
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
            <p><b>{{ $news["description"] }}</b></p>
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
@endif
@endsection
