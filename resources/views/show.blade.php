@extends('layouts.app')
@section('title', 'Task Details')
@section('content')
<h1>{{ $task->title }}</h1>
<p>{{ $task->description }}</p>

@if($task->long_description)
  <p>{{ $task->long_description }}</p>
@endif

<p>Created at: {{ $task->created_at }}</p>
<p>Updated at: {{ $task->updated_at }}</p>

<a href="{{ route('tasks.index') }}">Back to the list</a>
@endsection
