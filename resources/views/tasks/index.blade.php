@extends('layouts.master')

{{-- set page title --}}
@section('title', 'Danh sách tasks')

@section('content')
{{-- show message --}}
@if(Session::has('success'))
<p class="text-success">{{ Session::get('success') }}</p>
@endif

{{-- show error message --}}
@if(Session::has('error'))
<p class="text-danger">{{ Session::get('error') }}</p>
@endif
<a href="{{ route('tasks.create') }}" class="btn btn-info">Thêm mới</a>
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Tasks Name</th>
        <th>User</th>
        <th>Action</th>
        <th>Images</th>
    </tr>
    @foreach ($tasks as $key => $task)
    <tr>
        <td>{{ ++$key}}</td>
        <td>{{ $task->name }}</td>
        <td>{{ $task->user->name }}</td>
        <td>
            <a href="{{ route('tasks.show', ['id' => $task->id]) }}" class="btn btn-primary">xem chi tiết</a>
        </td>
        <td>
            <a href="{{ route('tasks.edit',  ['id' => $task->id])}}" class="btn btn-success">Chỉnh sửa</a>
        </td>
        <td>
            {{-- <form action="{{ route('tasks.destroy', ['id' => $task->id])}}" method="POST"> cách 1: normal --}}
            <form action="{{ route('tasks.destroy', ['task' => $task->id])}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('{{ __('message.confirm_delete') }}')"
                class="btn btn-danger">submit to delete</button>
            </form>
        </td>
        <td>
            @if($task->image)
            <img src="{{ $task->image }}" alt="{{ $task->name }}" />
            @endif
        </td>
    </tr>
    @endforeach
    
</table>
{{-- Cách 1: hiển thị không gắn tham số --}}
{{ $tasks->links() }}
{{-- Cách 2: hiển thị có gắn tham số --}}

@endsection

@push('css')
    <link rel="stylesheet" href="/css/task.css">
@endpush

@push('js')
    <script src="/js/task.js"></script>
@endpush
