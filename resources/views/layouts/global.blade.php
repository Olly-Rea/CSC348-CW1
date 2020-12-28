<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Page title --}}
        @yield("title")
        <!-- Styles -->
        @yield("styles")
        <!-- Referenced JQuery scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        @yield ('jquery')
        <!-- Scripts -->
        <script src="{{ asset('javascript/global.js') }}" defer></script>
        @yield("scripts-app")
    </head>

    <body>
        @if(!Request::is("/"))
        <a @guest()href="/"@else()@if(Request::is("feed"))href="#" @else()href="/feed" @endif()@endguest>
            <svg id="logo" class="live" style="display: none">
                <use xlink:href="{{ asset('images/graphics/logo.svg#icon') }}"></use>
            </svg>
        </a>
        @else
        <svg id="logo" style="display: none">
            <use xlink:href="{{ asset('images/graphics/logo.svg#icon') }}"></use>
        </svg>
        @endif
        <div id="loading-screen">
            <svg class="loading-graphic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82.1853 82.8107">
                <g fill-rule="evenodd">
                    <path class="elem" d="M57.12 25.724c0-2.412 1.9547-4.3666 4.3667-4.3666H77.151c2.412 0 4.366 1.9546 4.366 4.3666v15.6654c0 2.412-1.954 4.3666-4.366 4.3666H61.4867c-2.412 0-4.3667-1.9546-4.3667-4.3666z"/>
                    <path class="elem" d="M.6653 5.084C.6653 2.644 2.644.6654 5.084.6654h43.2587c2.44 0 4.4186 1.9786 4.4186 4.4186v20.6174c0 2.44-1.9786 4.4186-4.4186 4.4186H5.084c-2.44 0-4.4187-1.9786-4.4187-4.4186z"/>
                    <path class="elem" d="M13.992 63.948c-2.5107-2.508-2.5107-6.576 0-9.0866l16.2973-16.296c2.5107-2.5107 6.5787-2.5107 9.0867 0L55.6773 54.864c2.508 2.508 2.508 6.5787 0 9.0867l-16.3 16.299c-2.508 2.508-6.5773 2.508-9.0853 0z"/>
                </g>
            </svg>
        </div>
        @yield("pre-main")
        <main style="display: none">
            @yield("content")
        </main>
        <footer style="display: none">
            <a href="https://ollyrea.co.uk" target="_blank">Olly Rea - 950659</a>
        </footer>
    </body>
</html>
