@extends('layouts.master')
{{-- set page title --}}
@section('title', 'sửa task')
@section('content')
    <form action="{{ route('tasks.update',['id'=> $task->id])}}" method="POST" enctype="multipart/form-data"> 

        @csrf
        @method('PUT')
        
        <div class="md-5">
            <label for="">Task Name (*)</label>
            <input type="text" name="name" value="{{ old('name', $task->name)}}" class="form-control">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
           
        <div class="md-5">
            <label for="">User</label>
            <select name="user_id" class="form-control">
                @foreach($users as $key => $value)
                <option value="{{ $key }}"
                {{ old('user_id', $task->user_id) == $key ? ' selected="selected"' : '' }}>{{ $value }}</option>
                @endforeach;
            </select>
            @error('user_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="md-5">
            <label for="">Task Image</label>
            @if($task->image)
            <img src="{{$task->image }}" alt="{{ $task->name}}">
            @endif

            <input type="file" name="new_image" class="form-control">
            @error('new_image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <input type="submit" value="Update">
    
    </form>
@endsection