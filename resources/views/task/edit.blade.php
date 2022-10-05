
@extends('layouts.default')

@section('title') TODO編集画面({{ $task->description }})@endsection

@section('wrapper')
<div class="wrapper">
    <div class="header">
        <h1>TODO編集</h1>
        edit.blade.php
    </div>
    <div class="contents">
        @include('layouts.flash_message')
        table表示
        <form action="{{ route('task.update', $task->id) }}" method="post">
            @csrf
            @method('PUT')
            <table>
                <tr>
                    <th>id</th>
                    <td>{{ $task->id }}</td>
                </tr>
                <tr>
                    <th>description</th>
                    <td><input type="text" name="description" value="{{ $task->description }}"></td>
                </tr>
                <tr>
                    <th>done</th>
                    <td>
                        <select name="done" id="">
                            @if (!empty(old('done')))
                                <option value="0" @if (old('done') == 0) selected @endif>未完了</option>
                                <option value="1" @if (old('done') == 1) selected @endif>完了</option>
                            @else
                                <option value="0" @if ($task->done == 0) selected @endif>未完了</option>
                                <option value="1" @if ($task->done == 1) selected @endif>完了</option>
                            @endif
                        </select>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td><input type="submit" value="更新"></td>
                </tr>
            </table>
        </form>

        <hr>
        <table>
            <tr>
                <th>id</th>
                <th>description</th>
                <th>done</th>
                <th>created_at</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
            <tr>
                <td>{{ $task['id']}}</td>
                <td>{{ $task['description']}}</td>
                <td>{{ $task['done']}}</td>
                <td>{{ $task['created_at']}}</td>
                <td><a href="{{ route('task.edit', $task['id'])}}">編集</a></td>
            </tr>
        </table>
        <div>
            <a href="{{ route('task.index')}}">TODOリスト一覧へ</a>
        </div>
    </div>
    <div class="footer">
        @include('layouts.footer')
    </div>
</div>
@endsection
