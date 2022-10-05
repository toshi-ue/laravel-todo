<tr>
    <td>{{ $task->id }}</td>
    <td>{{ $task->description }}</td>
    <td>{{ $task->done }}</td>
    <td>{{ $task->created_at }}</td>
    <td><a href="{{ route('task.show', $task->id) }}">詳細</a></td>
    <td>
        <form action="{{ route('task.destroy', $task->id) }}" method="post">
            @csrf
            @method('DELETE')
            <input type="submit" value="削除">
        </form>
    </td>
</tr>
