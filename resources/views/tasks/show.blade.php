@extends('layouts.master')
{{-- set page title --}}
@section('title', 'show tasks')
@section('content')
    <div class="md-5">
        <label for=""> Task Name</label>
        <p>{{ $task->name }}</p>
    </div>

    <div class="md-5">
        <label for="">User</label>
        <p>{{ $task->user->name }}</p>
    </div>

   <p><a href="{{ route('tasks.index')}}" >Tasks List</a></p>
@endsection