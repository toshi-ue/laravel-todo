@extends('layouts.default')

@section('title') TODO詳細({{ $task['description'] }})@endsection

@section('wrapper')
<div class="wrapper">
    <div class="header">
        <h1>TODO詳細</h1>
    </div>
    <div class="contents">
        @include('layouts.flash_message')
        table表示
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
            </tr>
        </table>
    </div>
    <div class="footer">
        @include('layouts.footer')
    </div>
</div>
@endsection
