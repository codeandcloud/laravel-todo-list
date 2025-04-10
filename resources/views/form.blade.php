@extends ('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')


@section('content')
    <form method="POST"
          action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}">
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="mb-4">
            <label for="title">Title:</label>
            <input type="text"
                   id="title"
                   name="title"
                   @class(['border-red-500' => $errors->has('title')])
                   value="{{ $task->title ?? old('title') }}">
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description">Description</label>
            <textarea id="description"
                      name="description"
                      rows="5"
                      @class(['border-red-500' => $errors->has('description')])>{{ $task->description ?? old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="long_description">Long Description</label>
            <textarea id="long_description"
                      name="long_description"
                      rows="10"
                      @class(['border-red-500' => $errors->has('long_description')])>{{ $task->long_description ?? old('long_description') }}</textarea>
            @error('long_description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center gap-2">
            <button class="btn" type="submit">
                {{ isset($task) ? 'Update Task' : 'Add Task' }}
            </button>
            <a class="link"
               href="{{ route('tasks.index') }}">Cancel</a>
        </div>
    </form>
@endSection
