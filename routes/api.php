<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('tasks', 'Api\TaskController')->only(['index', 'store', 'show', 'edit', 'update', 'destroy']);
// FIXME: 以下のようにauthを設定してもログイン画面にリダイレクトされない([認証 8.x Laravel](https://readouble.com/laravel/8.x/ja/authentication.html))。ブラウザのコンソールでは `GET http://localhost:8000/api/tasks/34 401 (Unauthorized)`のエラーが表示される
// Route::resource('tasks', 'Api\TaskController')->only(['index', 'store', 'show', 'edit', 'destroy'])->middleware('auth');
// Route::group(['middleware' => ['api']], function () {
//     Route::resource('tasks', 'Api\TaskController')->only(['index', 'store', 'show', 'edit', 'destroy']);
// });
