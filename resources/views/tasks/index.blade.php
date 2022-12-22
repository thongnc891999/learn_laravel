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
        <th>Tasks ID</th>
        <th>Tasks Name</th>
        <th>Action</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td>1</td>
        <td>Task 1</td>
        <td>
            <a href="{{ route('tasks.show', ['id' => 1]) }}" class="btn btn-primary">xem chi tiết</a>
        </td>
        <td>
            <a href="{{ route('tasks.edit', ['id' => 1])}}" class="btn btn-success">Chỉnh sửa</a>
        </td>
        <td>
            <form action="{{ route('tasks.destroy',['id => 1'])}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('{{ __('message.confirm_delete') }}')"
                class="btn btn-danger">submit to delete</button>
            </form>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Task 2</td>
        <td>
            <a href="{{ route('tasks.show', ['id' => 2]) }}" class="btn btn-primary">xem chi tiết</a>
        </td>
        <td>
            <a href="{{ route('tasks.edit', ['id' => 2])}}" class="btn btn-success">Chỉnh sửa</a>
        </td>
        <td>
            <form action="{{ route('tasks.destroy',['id => 2'])}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('{{ __('message.confirm_delete') }}')"
                class="btn btn-danger">submit to delete</button>
            </form>
        </td>
    </tr>
</table>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/task.css">
@endpush

@push('js')
    <script src="/js/task.js"></script>
@endpush
