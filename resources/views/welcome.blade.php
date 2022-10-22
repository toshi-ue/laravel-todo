<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <div id="nav">
                <router-link to="/">Home</router-link>
                <router-link to="/about">About</router-link>
            </div>
            <router-view/>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
