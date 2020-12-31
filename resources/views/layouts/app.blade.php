@extends("layouts.global")

@section('scripts-app')
@auth
<script src="{{ asset('javascript/auth.js') }}" defer></script>
@else
<script src="{{ asset('javascript/guest.js') }}" defer></script>
@endauth
@yield('scripts')
@endsection

@section('pre-main')
<div id="feed-nav" style="display: none">
    <div id="nav-left">
        {{-- Search bar --}}
        <form id="search-box" action="">
            <div class="form-box">
                <svg id="search-icon">
                    <use xlink:href="{{ asset('images/graphics/search.svg#icon') }}"></use>
                </svg>
                <input id="search-bar" type="text" name="search" placeholder="I'm looking for..." onfocus="this.placeholder = ''" onfocusout="this.placeholder = 'I\'m looking for...'" />
            </div>
        </form>
    </div>
    <div id="nav-center">
        <div id="all" class="menu-item @if(Request::is('feed'))active @endif">
            <a href="@if(Request::is('feed'))# @else(){{ route('feed') }}@endif">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/all.svg#icon') }}"></use>
                </svg>
            </a>
            <h1>All</h1>
        </div>
        <div id="posts" class="menu-item @if(Request::is('feed/posts') || (Request::is('post/*') && !(Request::is('post/create') || Request::is('post/edit/*'))))active @endif">
            <a href="@if(Request::is('feed/posts'))# @else(){{ route('posts') }}@endif">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/post.svg#icon') }}"></use>
                </svg>
            </a>
            <h1>Posts</h1>
        </div>
        <div id="news" class="menu-item @if(Request::is('feed/news'))active @endif">
            <a href="@if(Request::is('feed/news'))# @else(){{ route('news') }}@endif">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/news.svg#icon') }}"></use>
                </svg>
            </a>
            <h1>News</h1>
        </div>
    </div>
    <div id="nav-right">
        @guest
        <div id="user-buttons">
            <button onclick="window.location.href='{{ route('login') }}'">Login</button>
            <button onclick="window.location.href='{{ route('register') }}'">Sign Up</button>
        </div>
        @else
        <div id="create" class="menu-item @if(Request::is('post/create') || Request::is('post/edit/*'))active @endif" >
            <a href="@if(Request::is('post/create') || Request::is('post/edit/*'))# @elseif((Auth::check() && isset($post)) && !(Request::is('Me')) && Auth::user()->id == $post->user->id){{ route('post.edit', $post->id) }} @else(){{ route('post.create') }}@endif">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/pen.svg#icon') }}"></use>
                </svg>
            </a>
            @if((Auth::check() && isset($post)) && !(Request::is('Me')) && Auth::user()->id == $post->user->id)
                <h1>Edit</h1>
            @else
                <h1>Create</h1>
            @endif
        </div>
        <div id="notifications" class="menu-item" >
            <a>
                <svg>
                    <use xlink:href="{{ asset('images/graphics/bell.svg#icon') }}"></use>
                </svg>
            </a>
            <h1>Notifications</h1>
        </div>
        @if (Request::is('Me'))
        <div id="logout" class="menu-item" >
            <a>
                <svg>
                    <use xlink:href="{{ asset('images/graphics/about.svg#icon') }}"></use>
                </svg>
            </a>
            <h1>Logout</h1>
        </div>
        @else
        <div id="profile" class="menu-item" >
            <a href="@if(Request::is('Me'))# @else(){{ route('me') }}@endif" class="profile-image-container">
                <div class="profile-image">
                    <img src="{{ asset('images/profile-default.svg') }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                </div>
            </a>
            <h1>{{ Auth::user()->first_name }}</h1>
        </div>
        @endif
        @endguest
    </div>
    @auth
    <div id="notification-container" style="display: none">
        <p>No new notifications!</p>
        {{-- <h4 class="notification">Demo notification!</h4> --}}
        {{-- <h4 class="notification">Demo notification!</h4> --}}
        {{-- <h4 class="notification">Demo notification!</h4> --}}
    </div>
    @endauth
</div>
<div id="site-overlay" style="display: none">
    @auth
    <div id="logout" class="prompt" style="display: none">
        <h1>Are you sure you want to logout?</h1>
        <button onclick="window.location.href='{{ route('logout') }}'; document.getElementById('logout-form').submit();">Logout</button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" hidden>
            @csrf
        </form>
        {{-- href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" --}}
        <p class="cancel-prompt">Cancel</p>
    </div>
    @else
    <div id="sign-up" class="prompt" style="display: none">
        <h1></h1>
        <button onclick="window.location.href='{{ route('register') }}'">Sign Up</button>
        <p class="cancel-prompt">Cancel</p>
    </div>
    @endauth
    <div id="message" class="prompt" style="display: none">
        <h1></h1>
        <button>Okay</button>
    </div>
    <div id="error" class="prompt" style="display: none">
        <h1></h1>
        <p>Try reloading the page and trying again</p>
        <button>Okay</button>
    </div>
    @yield('overlays')
</div>
@endsection
