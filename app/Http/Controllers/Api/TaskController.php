<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Task;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $display_count = $request->perPage;
        $tasks = Task::whereUserId(Auth::id())->orderBy('created_at', 'desc')->paginate($display_count);
        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        // [【Laravel入門】CRUD実装〜新規登録 - Qiita](https://qiita.com/yukibe/items/36ebeca50ecad3ee18f6#add%E3%82%A2%E3%82%AF%E3%82%B7%E3%83%A7%E3%83%B3)
        // [Laravel+PostgreSQL+Vue.jsでSPA開発【チュートリアル】 - OPTiM TECH BLOG](https://tech-blog.optim.co.jp/entry/2019/08/13/173000#:~:text=1%E4%BB%B6-,%E8%BF%BD%E5%8A%A0,-%3C%3Fphp%0Apublic%20function)
        $task = new Task();
        $task = $task->fill($request->all());
        $task->user_id = Auth::id();
        $task->save();
        return response('OK', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        \Log::debug(Auth::user());
        // FIXME: ユーザー情報を取得するためにユーザーidを取得したいが以下のエラーが発生して取得できない
        // [2022-10-27 16:58:15] local.ERROR: Class "App\Http\Controllers\Api\Auth" not found {"exception":"[object] (Symfony\\Component\\Debug\\Exception\\FatalThrowableError(code: 0)
        \Log::debug(Auth::check());
        return Task::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update($request->all());
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::where('id', $id)->delete();
    }
}
