@extends('layouts.app')

@section('title', 'List of Tasks')
@section('content')
    <nav class="mb-4">
        <a class="link"
           href="{{ route('tasks.create') }}">Create Task</a>
    </nav>
    @forelse ($tasks as $task)
        <div>
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}"
               @class([
                   'line-through' => $task->completed,
               ])>
                {{ $task->title }}
            </a>
        </div>
    @empty
        <div>There are no tasks!</div>
    @endforelse

    @if ($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection
