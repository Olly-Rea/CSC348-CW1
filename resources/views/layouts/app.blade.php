<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Page title --}}
        @yield("title")
        {{-- Styles --}}
        <link href="{{ asset('css/global.css') }}" rel="stylesheet">
        @yield("styles")
        {{-- Scripts --}}
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>

    <body>
        <main>
            @yield("content")
        </main>
        <footer>
            <a href="https://ollyrea.co.uk" target="_blank">Olly Rea - 950659</a>
        </footer>
    </body>
</html>
