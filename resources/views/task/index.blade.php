@extends('layouts.default')

@section('wrapper')
<div class="header">
    <h1>TODOリスト</h1>
</div>
<div class="contents">
    {{-- TODO: Task入力フォーム --}}
    {{-- TODO: done(true, false のよこならび表示) --}}
    table表示
    <table>
        <tr>
            <th>id</th>
            <th>description</th>
            <th>done</th>
            <th>created_at</th>
        </tr>
        @each('components.task', $tasks, 'task')
    </table>
</div>
<div class="footer">
    @include('layouts.footer')
</div>
@endsection
