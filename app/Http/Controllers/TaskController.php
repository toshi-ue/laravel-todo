<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::all();
        // $param = ['tasks' => $tasks,];
        // return view('task.index',  compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(TaskRequest $request)
    // {
    //     $task = Task::create($request->all());
    //     return redirect()->route('task.index')->with('success', 'TODOを登録しました');
    // }
    public function store(Request $request)
    {
        return Task::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     return Task::find($id);
    //     // $task = Task::find($id);
    //     // return view('task.show', compact('task'));
    // }
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(TaskRequest $request, $id)
    // {
    //     $task = Task::find($id);
    //     $form = $request->all();
    //     $task->fill($form)->save();
    //     return back()->with('success', '更新しました');
    // }
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     Task::where('id', $id)->delete();
    //     return redirect()->route('task.index')->with('success', 'TODOを削除しました');
    // }
    public function destroy(Task $task)
    {
        $task->delete();
        return $task;
    }
}
