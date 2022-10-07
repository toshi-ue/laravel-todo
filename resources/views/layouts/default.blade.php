<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    {{-- こういう書き方もできる --}}
    {{-- <title>{{ config('app.name', 'Ve')}}</title> --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div id="app">
        <example-component></example-component>
        @yield('wrapper')
    </div>
    {{-- TODO: BootStrap5 or TailWindCSSを追加する(CDN) --}}
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
