@extends('layouts.app')
@section('title', $task->title)
@section('content')
    <nav class="mb-4">
        <a class="link" href="{{ route('tasks.index') }}">
            <- Go Back to Tasks</a>
    </nav>

    <p class="mb-4 text-slate-700">{{ $task->description }}</p>

    @if ($task->long_description)
        <p class="mb-4 text-slate-700">{{ $task->long_description }}</p>
    @endif

    <p class="mb-4 text-sm text-slate-500">
        Created {{ $task->created_at->diffForHumans() }}
        | Updated {{ $task->updated_at->diffForHumans() }}
    </p>

    <p class="mb-4">
        <span @class([
            'font-medium text-green-500' => $task->completed,
            'font-medium text-red-500' => !$task->completed,
        ])>
            {{ $task->completed ? 'Completed' : 'Not Completed' }}
        </span>
    </p>

    <div class="flex gap-2">
        <a class="btn" href="{{ route('tasks.edit', ['task' => $task->id]) }}">Edit</a>

        <form method="POST" action={{ route('tasks.toggle-complete', ['task' => $task->id]) }}>
            @csrf
            @method('PUT')
            <button type="submit" class="btn">
                {{ $task->completed ? 'Mark as Not Completed' : 'Mark as Completed' }}
            </button>
        </form>

        <form method="POST" action={{ route('tasks.destroy', ['task' => $task->id]) }}>
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">Delete Task</button>
        </form>
    </div>
@endsection
