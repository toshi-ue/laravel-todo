@extends('layouts.default')

@section('wrapper')
<div class="header">
    <h1>TODOリスト</h1>
</div>
<div class="contents">
    {{-- TODO: Task入力フォーム --}}
    <form action="{{ route('task.store') }}" method="post">
        @csrf
        <table>
            <tr>
                <th>description</th>
            </tr>
            <tr>
                <td><input type="text" name="description" value="{{ old('description') }}"></td>
                <td><input type="submit" value="登録"></td>
            </tr>
        </table>
    </form>
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
