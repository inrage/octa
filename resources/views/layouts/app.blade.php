<!doctype html>
<html @php(language_attributes())>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
    @include('utils.styles')
</head>

<body @php(body_class())>
@php(wp_body_open())

<div id="app">
    <a class="sr-only focus:not-sr-only" href="#main">
        {{ __('Skip to content', 'octa') }}
    </a>

    @include('layouts.header')

    <main id="main" class="max-w-5xl mx-auto">
        @yield('content')
    </main>

    @include('layouts.footer')
</div>

@php(do_action('get_footer'))
@php(wp_footer())
@include('utils.scripts')
</body>
</html>
