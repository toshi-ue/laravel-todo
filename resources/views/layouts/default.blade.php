<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div id="app">
        <header-component></header-component>
        <router-view :key="$route.fullPath"></router-view>
        <footer-component></footer-component>
    </div>
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
