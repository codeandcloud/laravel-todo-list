@extends ('layouts.app')

@section('title', 'Add Task')

@section('styles')
    <style>
        .error {
            color: red;
            font-size: 0.8rem;
        }
    </style>
@endsection

@section('content')
    @include('form')
@endSection
