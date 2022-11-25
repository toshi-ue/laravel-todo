const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// ログイン直後のurlがhttp://localhost:8000/js/popper.js.mapになり、タスク一覧画面が表示されない問題の対策コード
// [Laravel5 Safariで閲覧！なぜかpopper.js 404(Not Found) | 株式会社Cruw（クルー）](https://cruw.co.jp/blog/safari-popper-404/)
mix.sourceMaps().js('node_modules/popper.js/dist/popper.js', 'public/js').sourceMaps();
