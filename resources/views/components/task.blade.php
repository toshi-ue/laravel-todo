<tr>
    <td>{{ $task['id']}}</td>
    <td>{{ $task['description']}}</td>
    <td>{{ $task['done']}}</td>
    <td>{{ $task['created_at']}}</td>
    <td><a href="{{ route('task.show', $task->id)}}">詳細</a></td>
    {{-- <td>{{ $task['created_at']}}</td> --}}
</tr>
