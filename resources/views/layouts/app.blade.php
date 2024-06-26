@extends("layouts.global")

@section('title')
{{ config('app.name', 'Laravel') }}
@endsection

@section('scripts-app')
@auth
<script src="{{ secure_asset('javascript/auth.js') }}" defer></script>
@else
<script src="{{ secure_asset('javascript/guest.js') }}" defer></script>
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
                    <use xlink:href="{{ secure_asset('images/graphics/search.svg#icon') }}"></use>
                </svg>
                <input id="search-bar" type="text" name="search" placeholder="I'm looking for..." onfocus="this.placeholder = ''" onfocusout="this.placeholder = 'I\'m looking for...'" />
            </div>
        </form>
    </div>
    <div id="nav-center">
        <div id="all" class="menu-item @if(Request::is('feed'))active @endif">
            <a href="@if(Request::is('feed'))# @else(){{ route('feed') }}@endif">
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/all.svg#icon') }}"></use>
                </svg>
            </a>
            <h1>All</h1>
        </div>
        <div id="posts" class="menu-item @if(Request::is('feed/posts') || (Request::is('post/*') && !(Request::is('post/create') || Request::is('post/edit/*'))))active @endif">
            <a href="@if(Request::is('feed/posts'))# @else(){{ route('posts') }}@endif">
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/post.svg#icon') }}"></use>
                </svg>
            </a>
            <h1>Posts</h1>
        </div>
        <div id="news" class="menu-item @if(Request::is('feed/news'))active @endif">
            <a href="@if(Request::is('feed/news'))# @else(){{ route('news') }}@endif">
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/news.svg#icon') }}"></use>
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
        @php
            $userAccess = ((Request::is('post/*') && !Request::is('post/create')) || Request::is('post/edit/*')) && ((Auth::check() && isset($post)) && Auth::user()->id == $post->user->id);
            $siteAdminAccess = ((Request::is('post/*') && !Request::is('post/create'))) && (Auth::check() && isset(Auth::user()->system_admin)) && Auth::user()->system_admin == true;
        @endphp
        <div id="create" class="menu-item @if(Request::is('post/create') || Request::is('post/edit/*'))active @endif">
            <a href="@if(Request::is('post/create') || Request::is('post/edit/*'))#@elseif($userAccess || $siteAdminAccess){{ route('post.edit', $post->id) }} @else(){{ route('post.create') }}@endif">
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/pen.svg#icon') }}"></use>
                </svg>
            </a>
            @if($userAccess || $siteAdminAccess)
                <h1>Edit</h1>
            @else
                <h1>Create</h1>
            @endif
        </div>
        <div id="notifications" class="menu-item" >
            <a>
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/bell.svg#icon') }}"></use>
                </svg>
                @php
                    $count = count(Auth::user()->unreadNotifications);
                @endphp
                @if($count > 0)
                <div class="notify-indicator">
                    @if($count > 9)
                    <p>+</p>
                    @else
                    <p>{{ count(Auth::user()->unreadNotifications) }}</p>
                    @endif
                </div>
                @endif
            </a>
            <h1>Notifications</h1>
        </div>
        @if (Request::is('Me'))
        <div id="logout" class="menu-item" >
            <a>
                <svg>
                    <use xlink:href="{{ secure_asset('images/graphics/logout.svg#icon') }}"></use>
                </svg>
            </a>
            <h1>Logout</h1>
        </div>
        @else
        <div id="profile" class="menu-item" >
            <a href="@if(Request::is('Me'))# @else(){{ route('me') }}@endif" class="profile-image-container">
                <div class="profile-image">
                    <img src="{{ Auth::user()->profile->profileImage() }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                </div>
            </a>
            <h1>{{ Auth::user()->first_name }}</h1>
        </div>
        @endif
        @endguest
    </div>
    @auth
    <div id="notification-container" style="display: none">
        <div>
            @forelse(Auth::user()->notifications as $notification)
                @if(Request::is('post/'.$notification->data["post_id"]))
                <a class="@if(isset($notification->read_at))seen @endif"><h4 id="{{ $notification->id }}" class="notification @if(isset($notification->read_at))seen @endif">{{ $notification->data["message"] }}</h4></a>
                @else
                <a href="{{ route('post', $notification->data["post_id"]) }}" class="@if(isset($notification->read_at))seen @endif"><h4 id="{{ $notification->id }}" class="notification @if(isset($notification->read_at))seen @endif">{{ $notification->data["message"] }}</h4></a>
                @endif
            @empty
                <p>No new notifications!</p>
            @endforelse
        </div>
    </div>
    @endauth
</div>
<div id="site-overlay" @if(!$errors->me->any())style="display: none"@endif>
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
    <div id="confirm" class="prompt" style="display: none">
        <h1>Are you sure?</h1>
        <p></p>
        <button>Okay</button>
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
    <div id="warning" class="prompt" style="display: none">
        <h1>Whoopsie!</h1>
        <p></p>
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
