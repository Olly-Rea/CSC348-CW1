@foreach($news as $news)
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
@endforeach
